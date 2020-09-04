<?php

namespace Oak\Database\Orm;

use Oak\Contracts\Database\Connection\ConnectionInterface;
use Oak\Contracts\Database\ConnectionManagerInterface;
use Oak\Database\ConnectionManager;
use Oak\Database\Traits\HasAttributes;

class Model
{
    use HasAttributes;
    
    /**
     * @var string $connection
     */
    protected $connection = 'default';

    /**
     * @var string $table
     */
    protected $table;
    
    /**
     * @var ConnectionManager $connectionManager
     */
    private $connectionManager;

    /**
     * Model constructor.
     * @param ConnectionManagerInterface $connectionManager
     */
    public function __construct(ConnectionManagerInterface $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connectionManager->connection($this->connection);
    }
}