<?php

namespace Oak\Contracts\Database;

use Oak\Contracts\Database\Connection\ConnectionInterface;

interface ConnectionManagerInterface
{
    public function connection(string $name = 'default'): ConnectionInterface;
}