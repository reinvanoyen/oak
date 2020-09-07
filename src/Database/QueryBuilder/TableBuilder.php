<?php

namespace Oak\Database\QueryBuilder;

use Oak\Database\QueryBuilder\Definitions\Column;
use Oak\Database\QueryBuilder\Definitions\ForeignKey;
use Oak\Database\QueryBuilder\Definitions\Unique;

class TableBuilder extends BuildHandler
{
    /**
     * @var bool
     */
    private $isAlter;

    /**
     * @var array $addColumns
     */
    private $addColumns = [];

    /**
     * @var array $changeColumns
     */
    private $changeColumns = [];

    /**
     * @var array $dropColumns
     */
    private $dropColumns = [];

    /**
     * @var array $dropForeignKeys
     */
    private $dropForeignKeys = [];

    /**
     * @var array $dropForeignKeyIdentifiers
     */
    private $dropForeignKeyIdentifiers = [];

    /**
     * @var array $addUniques
     */
    private $addUniques = [];

    /***
     * @var array $dropUniques
     */
    private $dropUniques = [];

    /**
     * @var array $addForeignKeys
     */
    private $addForeignKeys = [];

    /**
     * TableBuilder constructor.
     * @param bool $isAlter
     */
    public function __construct(bool $isAlter = false)
    {
        $this->isAlter = $isAlter;
    }

    /**
     * @param string $name
     * @param string $type
     * @return Column
     */
    public function addColumn(string $name, string $type)
    {
        $column = new Column($name);
        $column->type($type);
        $this->addColumns[] = $column;

        return $column;
    }
    
    /**
     * @param string $name
     * @return Column
     */
    public function changeColumn(string $name)
    {
        $column = new Column($name, true);
        $this->changeColumns[] = $column;

        return $column;
    }

    /**
     * @param string $column
     * @param string $foreignTable
     * @param string $foreignColumn
     */
    public function dropForeignKey(string $column, string $foreignTable, string $foreignColumn = 'id')
    {
        $foreignKey = new ForeignKey($this->getTable(), $column, $foreignTable, $foreignColumn);
        $this->dropForeignKeys[] = $foreignKey;
    }

    /**
     * @param string $identifier
     */
    public function dropForeignKeyByIdentifier(string $identifier)
    {
        $this->dropForeignKeyIdentifiers[] = $identifier;
    }

    /**
     * @param string $column
     * @param string $foreignTable
     * @param string $foreignColumn
     * @return ForeignKey
     */
    public function addForeignKey(string $column, string $foreignTable, string $foreignColumn = 'id')
    {
        $foreignKey = new ForeignKey($this->getTable(), $column, $foreignTable, $foreignColumn);
        $this->addForeignKeys[] = $foreignKey;

        return $foreignKey;
    }

    /**
     * @param string $column
     * @return Unique
     */
    public function addUnique(string $column)
    {
        $unique = new Unique($column);
        $this->addUniques[] = $unique;

        return $unique;
    }

    /**
     * @param string $column
     * @return Unique
     */
    public function dropUnique(string $column)
    {
        $unique = new Unique($column);
        $this->dropUniques[] = $unique;

        return $unique;
    }

    /**
     * @param string $name
     */
    public function dropColumn(string $name)
    {
        $this->dropColumns[] = $name;
    }
}