<?php

namespace Oak\Contracts\Database\QueryBuilder\Compiler;

use Oak\Database\QueryBuilder\QueryBuilder;

/**
 * Interface CompilerInterface
 * @package Oak\Contracts\Database\Compiler
 */
interface CompilerInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     */
    public function compile(QueryBuilder $queryBuilder);

    /**
     * @return string
     */
    public function getQuery(): string;

    /**
     * @return array
     */
    public function getParameters(): array;
}