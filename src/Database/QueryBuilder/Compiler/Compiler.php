<?php

namespace Oak\Database\QueryBuilder\Compiler;

use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;
use Oak\Database\QueryBuilder\QueryBuilder;

class Compiler implements CompilerInterface
{
    private $query;
    
    public function compile(QueryBuilder $queryBuilder): string
    {
        $this->query = '';
        
        $table = $queryBuilder->getTable();
        $select = $queryBuilder->getSelect();
        
        if ($select) {
            $this->query .= 'SELECT ';
            $this->query .= implode(',', $select);
            $this->query .= ' FROM '.$table;
        }
        
        return $this->query;
    }
}