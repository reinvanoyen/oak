<?php

namespace Oak\Container;

use Exception;
use Oak\Contracts\Container\ContainerInterface;
use ReflectionClass;

/**
 * Class Container
 * @package Oak\Container
 */
class Container implements ContainerInterface
{
    /**
     * All stored contracts and their implementations
     *
     * @var array
     */
    private $contracts = [];

    /**
     * Array of contracts we wish to use as singletons
     *
     * @var array
     */
    private $singletons = [];

    /**
     * Instances of contracts for singleton use
     *
     * @var array
     */
    private $instances = [];

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * Stores a implementation in the container for the given key
     *
     * @param string $key
     * @param mixed $implementation
     */
    public function set(string $contract, $implementation)
    {
        $this->contracts[$contract] = $implementation;
    }

    /**
     * Checks if the container has a value by a given contract
     *
     * @param string $contract
     * @return bool
     */
    public function has(string $contract): bool
    {
        return isset($this->contracts[$contract]);
    }

    /**
     * Stores a implementation in the container for the given key and also store it as a singleton
     *
     * @param string $contract
     * @param mixed $implementation
     */
    public function singleton(string $contract, $implementation)
    {
        $this->set($contract, $implementation);
        $this->singletons[] = $contract;
    }

    /**
     * Directly store an instance for a contract
     *
     * @param string $contract
     * @param $instance
     */
    public function instance(string $contract, $instance)
    {
        $this->set($contract, get_class($instance));
        $this->instances[$contract] = $instance;
    }

    /**
     * Retreives a value from the container by a given contract
     *
     * @param string $contract
     * @return mixed
     * @throws \Exception
     */
    public function get(string $contract)
    {
        // Looks like we're getting a singleton instance,
        // So we should check if it was instantiated before
        // If so we retrieve it
        if (isset($this->instances[$contract])) {
            return $this->instances[$contract];
        }

        if (!in_array($contract, $this->singletons)) {
            return $this->create($contract);
        }

        // It wasn't instantiated before, so we create and save it now
        $this->instances[$contract] = $instance = $this->create($contract);

        // Give back the instance
        return $instance;
    }

    /**
     * @param string $contract
     * @param string $arg
     * @param $value
     */
    public function whenAsksGive(string $contract, string $argument, $value)
    {
        if (! isset($this->arguments[$contract])) {
            $this->arguments[$contract] = [];
        }

        $this->arguments[$contract][$argument] = $value;
    }

    /**
     * @param string $contract
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function getWith(string $contract, array $arguments)
    {
        return $this->create($contract, $arguments);
    }

    /**
     * Creates an instance from a contract
     *
     * @param string $contract
     * @return mixed
     * @throws \Exception
     */
    private function create(string $contract, array $arguments = [])
    {
        // First check if we can find an implementation for the requested contract
        if (! $this->has($contract)) {
            if (class_exists($contract)) {
                $implementation = $contract;
            } else {
                throw new \Exception('Could not create dependency with contract: '.$contract);
            }
        } else {
            $implementation = $this->contracts[$contract];
        }

        // Check if we have to give this class some stored arguments
        if (is_string($implementation) && isset($this->arguments[$implementation])) {
            $arguments = array_merge($arguments, $this->arguments[$implementation]);
        }

        // Is it callable? Call it right away and return the results
        if (is_callable($implementation)) {
            return call_user_func($implementation, $this);
        }

        $reflect = new ReflectionClass($implementation);
        $constructor = $reflect->getConstructor();

        if ($constructor === null) {
            return new $implementation;
        }

        $parameters = $constructor->getParameters();

        if (!count($parameters)) {
            return new $implementation;
        }

        $injections = [];

        foreach ($parameters as $parameter) {

            // Check if param is a class
            if ($class = $parameter->getClass()) {

                $className = $class->name;

                // Check if it was explicitely given as an argument
                if (isset($arguments[$className])) {

                    // Get the explicit argument from the container
                    $injections[] = $this->get($arguments[$className]);
                    continue;

                }

                // Get the class from the container
                $injections[] = $this->get($className);

                continue;

            } else {

                $argName = $parameter->getName();

                // Check if the argument was explicitely given
                if (isset($arguments[$argName])) {

                    $injections[] = $arguments[$argName];
                    continue;

                }

                // Check if the argument has a default value
                if($parameter->isDefaultValueAvailable()) {

                    // Inject the default value
                    $injections[] = $parameter->getDefaultValue();
                    continue;
                }
            }

            throw new Exception('Could not provide argument "'.$parameter->getName().'" to '.$contract);
        }

        return $reflect->newInstanceArgs($injections);
    }
}