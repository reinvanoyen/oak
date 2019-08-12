<?php

namespace Oak\Console\Command;

/**
 * Class Signature
 * @package Oak\Console\Command
 */
class Signature
{
	/**
	 * The name of the command
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The description of the command
	 *
	 * @var string
	 */
	private $description = '';

	/**
	 * An array holding the arguments
	 *
	 * @var array
	 */
	private $arguments = [];

	/**
	 * An array holding the possible options
	 *
	 * @var array
	 */
	private $options = [];

	/**
	 * An array holding the subcommands
	 *
	 * @var array
	 */
	private $subCommands = [];

	/**
	 * Gets the name of the command
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * Sets the name of the command
	 *
	 * @param string $name
	 */
	public function setName(string $name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * Checks if the command has a name
	 *
	 * @return bool
	 */
	public function hasName(): bool
	{
		return (bool) $this->name;
	}

	/**
	 * Add an argument
	 *
	 * @param Argument $argument
	 */
	public function addArgument(Argument $argument)
	{
		$this->arguments[] = $argument;
		return $this;
	}

	/**
	 * Gets all arguments
	 *
	 * @return array
	 */
	public function getArguments(): array
	{
		return $this->arguments;
	}

	/**
	 * Add a subcommand
	 *
	 * @param Command $command
	 */
	public function addSubCommand(Command $command)
	{
		$this->subCommands[$command->getName()] = $command;
		return $this;
	}

	/**
	 * Get subcommand by name
	 *
	 * @param string $name
	 * @return Command
	 */
	public function getSubCommand(string $name): Command
	{
		return $this->subCommands[$name];
	}

	/**
	 * Gets all subcommands
	 *
	 * @return array
	 */
	public function getSubCommands(): array
	{
		return $this->subCommands;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasSubCommand(string $name): bool
	{
		return isset($this->subCommands[$name]);
	}

	/**
	 * Add an option
	 *
	 * @param Option $option
	 */
	public function addOption(Option $option)
	{
		$this->options[] = $option;
		return $this;
	}

	/**
	 * Gets all options
	 *
	 * @return array
	 */
	public function getOptions(): array
	{
		return $this->options;
	}
}