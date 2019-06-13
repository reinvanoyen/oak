<?php

namespace Oak\Container;

use Oak\Contracts\ContainerInterface;
use ReflectionClass;

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
	 * @param array $arguments
	 * @return mixed
	 * @throws \Exception
	 */
	public function getWith(string $contract, array $arguments)
	{
		return $this->create($contract, $arguments);
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
			throw new \Exception('Could not create dependency with contract: '.$contract);
		}

		$implementation = $this->contracts[$contract];

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

			// Check if the parameter was given
			if (isset($arguments[$parameter->getName()])) {
				$injections[] = $arguments[$parameter->getName()];
				continue;
			}

			// It's a dependency, so inject it
			$class = $parameter->getClass()->name;
			$injections[] = $this->get($class);
		}

		return $reflect->newInstanceArgs($injections);
	}
}