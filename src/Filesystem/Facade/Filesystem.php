<?php

namespace Oak\Filesystem\Facade;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Facade;

/**
 * Filesystem facade for easy access to the concrete implementation of FilesystemInterface.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Filesystem extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return FilesystemInterface::class;
    }
}