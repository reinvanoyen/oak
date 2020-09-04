<?php

namespace Oak\Contracts\Database\QueryBuilder;

/**
 * Interface StatementInterface
 * @package Oak\Contracts\Database\QueryBuilder
 */
interface StatementInterface
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