<?php

namespace Oak\Database\QueryBuilder\Compiler;

use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;
use Oak\Database\QueryBuilder\QueryBuilder;

/**
 * Class responsible for compiling a QueryBuilder instance to
 * a query in string format and its parameters, ready to be used by a connection.
 * 
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Compiler implements CompilerInterface
{
    
    /**
     * @var string $query
     */
    private $query = '';

    /**
     * @var array $parameters
     */
    private $parameters = [];

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function compile(QueryBuilder $queryBuilder)
    {
        $this->reset();
        
        $table = $queryBuilder->getTable();
        
        if ($select = $queryBuilder->getSelect()) {
            
            $selectValues = [];
            foreach ($select as $expr) {
                $selectValues[] = $expr->getValue();
            }
            
            $this->query .= 'SELECT ';
            $this->query .= implode(', ', $selectValues);
            $this->query .= ' FROM '.$table;
            
            $this->compileWhere($queryBuilder->getWhere());
            $this->compileLimitOffset($queryBuilder->getLimit(), $queryBuilder->getOffset());
            
        } else if ($drop = $queryBuilder->getDrop()) {

            $this->query .= 'DROP TABLE '.$table;
        }
    }

    /**
     * @param array $where
     */
    private function compileWhere(array $where)
    {
        $this->compileConditions($where, 'WHERE');
    }

    /**
     * @param $limit
     * @param $offset
     */
    private function compileLimitOffset($limit, $offset)
    {
        if ($limit) {
            $this->query .= ' LIMIT '.$limit->getValue();
            $this->addParameters($limit->getBindings());
            
            if ($offset) {
                $this->query .= ' OFFSET '.$offset->getValue();
                $this->addParameters($offset->getBindings());
            }
        }
    }

    /**
     * @param array $conditions
     * @param string $keyword
     */
    private function compileConditions(array $conditions, string $keyword)
    {
        if (!count($conditions)) {
            return;
        }

        $this->query .= ' '.$keyword.' ';

        $i = 0;
        foreach ($conditions as $condition) {
            $this->compileCondition($condition, ($i === 0));
            $i++;
        }
    }

    /**
     * @param array $condition
     * @param bool $isFirst
     */
    private function compileCondition(array $condition, bool $isFirst = true)
    {
        $expr1 = $condition[0];
        $operator = $condition[1];
        $expr2 = $condition[2];

        if (! $isFirst) {
            $this->query .= ' AND ';
        }
        
        $this->query .= $expr1->getValue().' '.$operator.' '.$expr2->getValue();
        
        $this->addParameters($expr1->getBindings());
        $this->addParameters($expr2->getBindings());
    }

    /**
     * 
     */
    private function reset()
    {
        $this->query = '';
        $this->parameters = [];
    }
    
    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }
}