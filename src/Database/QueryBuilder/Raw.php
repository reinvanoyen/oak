<?php

namespace Oak\Database\QueryBuilder;

use Oak\Contracts\Database\QueryBuilder\StatementInterface;

class Raw implements StatementInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     */
    private $bindings;

    /**
     * Raw constructor.
     * @param string $value
     * @param array $bindings
     */
    public function __construct(string $value, array $bindings = [])
    {
        $this->value = $value;
        $this->bindings = $bindings;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }
}