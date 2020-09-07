<?php

namespace Oak\Database\QueryBuilder\Definitions;

class Column
{
    /**
     * @var bool $isAlter
     */
    private $isAlter;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var $newName
     */
    private $newName;

    /**
     * @var mixed $length
     */
    private $length;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var bool $null
     */
    private $null;

    /**
     * @var bool $autoIncrement
     */
    private $autoIncrement = false;

    /**
     * @var bool $primaryKey
     */
    private $primaryKey = false;

    /**
     * ColumnDefinition constructor.
     * @param string $name
     * @param bool $isAlter
     */
    public function __construct(string $name, bool $isAlter = false)
    {
        $this->name = $name;
        $this->isAlter = $isAlter;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $name
     * @param string $type
     * @param int|null $length
     * @return $this
     */
    public function rename(string $name, string $type, int $length = null)
    {
        $this->newName = $name;
        $this->type = $type;

        if ($length) {
            $this->length = $length;
        }

        return $this;
    }

    /**
     * @param mixed $length
     * @return $this
     */
    public function length($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return $this
     */
    public function primaryKey()
    {
        $this->autoIncrement = true;
        $this->primaryKey = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function null()
    {
        $this->null = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function notNull()
    {
        $this->null = false;
        return $this;
    }
}