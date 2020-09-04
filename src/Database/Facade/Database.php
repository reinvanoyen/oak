<?php

namespace Oak\Database\Facade;

use Oak\Database\ConnectionManager;
use Oak\Facade;

/**
 * Database facade for easy access.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
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