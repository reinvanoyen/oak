<?php

namespace Oak\Database;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Database\Connection\ConnectionInterface;
use Oak\Database\Connection\MysqlConnection;

class ConnectionFactory
{
    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * ConnectionFactory constructor.
     * @param RepositoryInterface $config
     */
    public function __construct(RepositoryInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @return ConnectionInterface
     * @throws \Exception
     */
    public function make(string $name): ConnectionInterface
    {
        $connectionConfig = $this->config->get('database.connections.'.$name);
        
        if ($connectionConfig['driver'] === 'mysql') {
            return new MysqlConnection($this->buildDsn($connectionConfig), $connectionConfig['user'], $connectionConfig['password']);
        }
        
        throw new \Exception('Driver not recognised');
    }
    
    private function buildDsn(array $connectionConfig)
    {
        return $connectionConfig['driver'].':dbname='.$connectionConfig['database'].';host='.$connectionConfig['host'].';port='.$connectionConfig['port'].';charset='.$connectionConfig['charset'];
    }
}