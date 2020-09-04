<?php

namespace Oak\Database;

use Oak\Contracts\Database\Connection\ConnectionInterface;
use Oak\Contracts\Database\ConnectionManagerInterface;

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
    
    public function connection(string $name = 'default'): ConnectionInterface
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }
        
        $this->connections[$name] = $this->connectionFactory->make($name);
        return $this->connections[$name];
    }
}