<?php

namespace Oak\Database\Orm;

use Oak\Contracts\Database\Connection\ConnectionInterface;
use Oak\Contracts\Database\ConnectionManagerInterface;
use Oak\Database\ConnectionManager;
use Oak\Database\Traits\HasAttributesTrait;

/**
 * Class representing a database entity
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Model
{
    use HasAttributesTrait;
    
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
     * @throws \Exception
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connectionManager->connection($this->connection);
    }
}