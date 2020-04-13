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
}