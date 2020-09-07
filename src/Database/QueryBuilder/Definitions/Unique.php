<?php

namespace Oak\Database\QueryBuilder\Definitions;

class Unique
{
    /**
     * @var string $column
     */
    private $column;

    /**
     * Unique constructor.
     * @param string $column
     */
    public function __construct(string $column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'uq_'.$this->column;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }
}