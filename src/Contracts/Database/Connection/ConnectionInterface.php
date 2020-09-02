<?php

namespace Oak\Contracts\Database\Connection;

interface ConnectionInterface
{
    public function connect();
    public function disconnect();
    public function getPdo(): \PDO;
}