<?php

namespace Oak\Contracts\Database\QueryBuilder;

/**
 * Interface ExpressionInterface
 * @package Oak\Contracts\Database\QueryBuilder
 */
interface ExpressionInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return array
     */
    public function getBindings(): array;
}