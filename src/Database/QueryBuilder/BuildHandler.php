<?php

namespace Oak\Database\QueryBuilder;

use Oak\Contracts\Database\QueryBuilder\ExpressionInterface;
use Oak\Database\QueryBuilder\Expressions\Raw;

abstract class BuildHandler
{
    protected $table;
    
    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param $expr
     * @param bool $prefix
     * @return ExpressionInterface
     */
    protected function createExpression($expr, $prefix = false): ExpressionInterface
    {
        if ($expr instanceof ExpressionInterface) {
            return $expr;
        }

        return ($prefix ? new Raw($this->prefix($expr)) : new Raw('?', [$expr,]));
    }

    /**
     * @param string $column
     * @return string
     */
    protected function prefix(string $column): string
    {
        $table = $this->table;
        $parts = explode('.', $column, 2);

        if (count($parts) > 1) {
            $table = $parts[0];
            $column = $parts[1];
        }

        return $this->quote($table).'.'.$this->quote($column);
    }

    /**
     * @param string $statement
     * @return string
     */
    final protected function quote(string $statement)
    {
        return '`'.$statement.'`';
    }
}