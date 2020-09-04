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
     * @return string
     */
    public function compile(QueryBuilder $queryBuilder): string;
}