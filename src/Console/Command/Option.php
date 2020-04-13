<?php

namespace Oak\Console\Command;

/**
 * Class Option
 * @package Oak\Console\Command
 */
class Option
{
    /**
     * Name of the option
     *
     * @var string
     */
    private $name;

    /**
     * Alias for the option name
     *
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var bool $default
     */
    private $default = true;

    /**
     * Option constructor.
     * @param string $name
     * @param string $alias
     */
    private function __construct(string $name, string $alias = '')
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    /**
     * Public method to instantiate the option
     *
     * @param string $name
     * @param string $alias
     * @return static
     */
    public static function create(string $name, string $alias = '')
    {
        return new static($name, $alias);
    }

    /**
     * Gets the name of the option
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the alias of the option
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Gets the description of the option
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function getDefault(): bool
    {
        return $this->default;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }
}