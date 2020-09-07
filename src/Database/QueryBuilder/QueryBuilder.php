<?php

namespace Oak\Database\QueryBuilder;

use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;
use Oak\Contracts\Database\QueryBuilder\ExpressionInterface;
use Oak\Database\QueryBuilder\Expressions\Raw;

/**
 * This class provides a dynamic PHP API around building queries.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class QueryBuilder extends BuildHandler
{
    /**
     * @var array $select
     */
    private $select = [];

    /**
     * @var bool $drop
     */
    private $drop = false;

    /**
     * @var callable $create
     */
    private $create;

    /**
     * @var callable $alter
     */
    private $alter;
    
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
     * @var array $groupBy
     */
    private $groupBy = [];

    /**
     * @var array $orderBy
     */
    private $orderBy = [];

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

    /**
     * @param callable $createScheme
     * @return QueryBuilder
     */
    public function create(callable $createScheme): QueryBuilder
    {
        $this->create = $createScheme;
        return $this;
    }

    /**
     * @param callable $alterScheme
     * @return QueryBuilder
     */
    public function alter(callable $alterScheme): QueryBuilder
    {
        $this->alter = $alterScheme;
        return $this;
    }
    
    /**
     * @param $expr1
     * @param string $operator
     * @param $expr2
     * @return QueryBuilder
     */
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
     * @param $column
     * @return QueryBuilder
     */
    public function groupBy($column): QueryBuilder
    {
        $this->groupBy[] = $this->createExpression($column, true);
        return $this;
    }

    /**
     * @param $column
     * @param string $sortMethod
     * @return QueryBuilder
     */
    public function orderBy($column, string $sortMethod = 'ASC'): QueryBuilder
    {
        $field = $this->createExpression($column, true);
        
        $this->orderBy = array_filter($this->orderBy, function($value) use($field) {
            return ($value[0]->getValue() !== $field->getValue());
        });
        
        $this->orderBy[] = [$field, $sortMethod,];
        return $this;
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
     * @return array
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }
    
    /**
     * 
     */
    public function build()
    {
        $this->compiler->compile($this);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->compiler->getQuery();
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->compiler->getParameters();
    }
}