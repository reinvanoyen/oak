<?php

namespace Oak\Database\QueryBuilder;

use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;
use Oak\Contracts\Database\QueryBuilder\ExpressionInterface;

/**
 * This class provides a dynamic PHP API around building queries.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class QueryBuilder
{
    /**
     * @var string $table
     */
    private $table;

    /**
     * @var array $select
     */
    private $select = [];

    /**
     * @var array $where
     */
    private $where = [];

    /**
     * @var ExpressionInterface $limit
     */
    private $limit;
    
    /**
     * @var ExpressionInterface $offset
     */
    private $offset;

    /**
     * @var bool $drop
     */
    private $drop;

    /**
     * @var CompilerInterface $compiler
     */
    private $compiler;

    /**
     * QueryBuilder constructor.
     * @param CompilerInterface $compiler
     */
    public function __construct(CompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * @param string $table
     * @return QueryBuilder
     */
    public function table(string $table): QueryBuilder
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param array $columns
     * @return QueryBuilder
     */
    public function select($columns = []): QueryBuilder
    {
        if (! count($columns)) {
            $this->select = [new Raw('*'),];
        }
        
        foreach ($columns as $column) {
            $this->select[] = $this->createExpression($column, true);
        }
        
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function drop(): QueryBuilder
    {
        $this->drop = true;
        return $this;
    }
    
    public function where($expr1, string $operator, $expr2): QueryBuilder
    {
        $this->where[] = [
            $this->createExpression($expr1, true),
            $operator,
            $this->createExpression($expr2),
        ];
        return $this;
    }

    /**
     * @param $limit
     * @return QueryBuilder
     */
    public function limit($limit): QueryBuilder
    {
        $this->limit = $this->createExpression($limit);
        return $this;
    }

    /**
     * @param $offset
     * @return QueryBuilder
     */
    public function offset($offset): QueryBuilder
    {
        $this->offset = $this->createExpression($offset);
        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
    
    /**
     * @return bool
     */
    public function getDrop(): bool
    {
        return $this->drop;
    }

    /**
     * @return array
     */
    public function getWhere(): array 
    {
        return $this->where;
    }
    
    /**
     * @return array
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @return ExpressionInterface|null
     */
    public function getLimit(): ?ExpressionInterface
    {
        return $this->limit;
    }

    /**
     * @return ExpressionInterface|null
     */
    public function getOffset(): ?ExpressionInterface
    {
        return $this->offset;
    }

    /**
     * @param $statement
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
    
    /**
     * 
     */
    public function build()
    {
        $this->compiler->compile($this);
    }
    
    public function getQuery()
    {
        return $this->compiler->getQuery();
    }

    public function getParameters()
    {
        return $this->compiler->getParameters();
    }
}