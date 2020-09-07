<?php

namespace Oak\Contracts\Database\QueryBuilder\Compiler;

use Oak\Database\QueryBuilder\BuildHandler;

/**
 * Interface CompilerInterface
 * @package Oak\Contracts\Database\Compiler
 */
interface CompilerInterface
{
    /**
     * @param BuildHandler $buildHandler
     * @return mixed
     */
    public function compile(BuildHandler $buildHandler);

    /**
     * @return string
     */
    public function getQuery(): string;

    /**
     * @return array
     */
    public function getParameters(): array;
}