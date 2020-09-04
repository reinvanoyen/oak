<?php

namespace Oak\Database;

use Oak\Contracts\Database\Connection\ConnectionInterface;
use Oak\Contracts\Database\ConnectionManagerInterface;

/**
 * This class is responsible for managing (storing, retrieving) all created connections.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class ConnectionManager implements ConnectionManagerInterface
{
    /**
     * @var ConnectionFactory $connectionFactory
     */
    private $connectionFactory;

    /**
     * @var array $connections
     */
    private $connections = [];

    /**
     * ConnectionManager constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @param string $name
     * @return ConnectionInterface
     * @throws \Exception
     */
    public function connection(string $name = 'default'): ConnectionInterface
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }
        
        $this->connections[$name] = $this->connectionFactory->make($name);
        return $this->connections[$name];
    }
}