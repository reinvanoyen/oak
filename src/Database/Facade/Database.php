<?php

namespace Oak\Database\Facade;

use Oak\Database\ConnectionManager;
use Oak\Facade;

class Database extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return ConnectionManager::class;
    }
}