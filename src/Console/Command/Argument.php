<?php

namespace Oak\Console\Command;

/**
 * Class Argument
 * @package Oak\Console\Command
 */
class Argument
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $description = '';

	/**
	 * Argument constructor.
	 * @param string $name
	 */
	private function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * Public method to instantiate the argument
	 *
	 * @param string $name
	 * @return static
	 */
	public static function create(string $name)
	{
		return new static($name);
	}

	/**
	 * Gets the name of the argument
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * Gets the description of the argument
	 *
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * Sets the description of the argument
	 *
	 * @param string $description
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;
		return $this;
	}
}