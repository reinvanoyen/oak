<?php

namespace Oak\Logger\Facade;

use Oak\Contracts\Logger\LoggerInterface;
use Oak\Facade;

/**
 * Logger facade for easy access.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
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