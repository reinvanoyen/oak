<?php

namespace Oak\Console\Input;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;

/**
 * Class Input
 * @package Oak\Console\Input
 */
abstract class Input implements InputInterface
{
    /**
     * @var array $rawArguments
     */
    protected $rawArguments = [];

    /**
     * @var array $missingArguments
     */
    protected $missingArguments = [];

    /**
     * Holds the given arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Holds the given options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Holds the given subcommand
     */
    protected $subCommand;

    /**
     * The signature of the command
     *
     * @var Signature
     */
    private $signature;

    /**
     * Gets all given arguments
     *
     * @return array
     */
    final public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Gets the argument by index
     *
     * @param int $name
     * @return mixed|null
     */
    final public function getArgument(string $name)
    {
        return $this->arguments[$name] ?? null;
    }

    /**
     * Checks if the argument was given
     *
     * @param int $index
     * @return bool
     */
    final public function hasArgument(string $name): bool
    {
        return isset($this->arguments[$name]);
    }

    /**
     * Sets an argument
     *
     * @param string $name
     * @param $value
     */
    final public function setArgument(string $name, $value)
    {
        $this->arguments[$name] = $value;
    }

    /**
     * Get all given options
     *
     * @return array
     */
    final public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get an option
     *
     * @param string $name
     * @return mixed|null
     */
    final public function getOption(string $name)
    {
        return $this->options[$name] ?? null;
    }

    /**
     * Sets an option
     *
     * @param string $name
     * @param mixed $value
     */
    public function setOption(string $name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Checks if the input has a subcommand
     *
     * @return bool
     */
    public function hasSubCommand(): bool
    {
        return (bool) $this->subCommand;
    }

    /**
     * Gets the subcommand
     *
     * @return mixed
     */
    final public function getSubCommand()
    {
        return $this->subCommand;
    }

    /**
     * Sets the subcommand
     *
     * @param string $name
     */
    final public function setSubCommand(string $name)
    {
        $this->subCommand = $name;
    }

    /**
     * Binds the signature to the input
     *
     * @param Signature $signature
     */
    public function setSignature(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Gets the binded signature
     *
     * @return Signature
     */
    public function getSignature(): Signature
    {
        return $this->signature;
    }

    /**
     * Parse the raw arguments
     */
    protected function parseRawArguments()
    {
        // First we check if any subcommand was requested
        if (isset($this->rawArguments[0])) {
            foreach ($this->getSignature()->getSubCommands() as $command) {
                if ($this->rawArguments[0] === $command->getName()) {
                    $this->setSubCommand($command->getName());
                    break;
                }
            }
        }

        // Then we parse out the options
        foreach ($this->getSignature()->getOptions() as $option) {

            $definitions = [
                '-'.$option->getName(),
                '--'.$option->getName(),
            ];

            if ($alias = $option->getAlias()) {
                $definitions[] = '-'.$alias;
                $definitions[] = '--'.$alias;
            }

            foreach ($definitions as $definition) {
                $optionPosition = array_search($definition, $this->rawArguments);

                if ($optionPosition !== false) {

                    // We found the option in the list of given arguments
                    if (
                        isset($this->rawArguments[$optionPosition + 1]) &&
                        substr($this->rawArguments[$optionPosition + 1], 0, strlen('-')) !== '-'
                    ) {
                        // We also found a value for the option
                        // We remove the value of the option from the argument list
                        $optionValue = $this->rawArguments[$optionPosition + 1];
                        $this->setOption($option->getName(), $optionValue);
                        array_splice($this->rawArguments, $optionPosition + 1, 1);

                    } else {

                        $this->setOption($option->getName(), $option->getDefault());
                    }

                    array_splice($this->rawArguments, $optionPosition, 1);
                    break;
                }
            }
        }

        // Now we loop all arguments and make sure they are present
        foreach ($this->getSignature()->getArguments() as $position => $argument) {
            if (isset($this->rawArguments[$position])) {
                $this->setArgument($argument->getName(), $this->rawArguments[$position]);
            } else {
                $this->missingArguments[] = $argument->getName();
            }
        }
    }
}