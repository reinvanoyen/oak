<?php

namespace Oak\Logger\Facade;

use Oak\Contracts\Logger\LoggerInterface;
use Oak\Facade;

class Logger extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return LoggerInterface::class;
    }
}