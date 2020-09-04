<?php

namespace Oak\Database\QueryBuilder;

use Oak\Contracts\Database\QueryBuilder\Compiler\CompilerInterface;
use Oak\Contracts\Database\QueryBuilder\StatementInterface;

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
            $columns = ['*'];
        }
        
        $this->select = $columns;
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
     * @return array
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @param $statement
     * @return StatementInterface
     */
    protected function createStatement($statement): StatementInterface
    {
        if ($statement instanceof StatementInterface) {
            return $statement;
        }
        
        return new Raw('?', [$statement, ]);
    }

    /**
     * @return string
     */
    public function build(): string
    {
        return $this->compiler->compile($this);
    }
}