<?php

namespace Oak\Database\QueryBuilder\Definitions;

class ForeignKey
{
    /**
     * @var string $table
     */
    private $table;

    /**
     * @var string $column
     */
    private $column;

    /**
     * @var string $foreignTable
     */
    private $foreignTable;

    /**
     * @var string $foreignColumn
     */
    private $foreignColumn;
    
    /**
     * @var string $identifierName
     */
    private $identifierName;

    /**
     * ForeignKeyDefinition constructor.
     * @param string $table
     * @param string $column
     * @param string $foreignTable
     * @param string $foreignColumn
     */
    public function __construct(string $table, string $column, string $foreignTable, string $foreignColumn)
    {
        $this->table = $table;
        $this->column = $column;
        $this->foreignTable = $foreignTable;
        $this->foreignColumn = $foreignColumn;
    }

    /**
     * @param string $identifierName
     * @return $this
     */
    public function identifier(string $identifierName)
    {
        $this->identifierName = $identifierName;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return ($this->identifierName ?: 'fk_'.$this->table.'_'.$this->column.'_'.$this->foreignTable.'_'.$this->foreignColumn);
    }

    /**
     * @return string
     */
    public function getForeignColumn()
    {
        return $this->foreignColumn;
    }

    /**
     * @return string
     */
    public function getForeignTable()
    {
        return $this->foreignTable;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }
}