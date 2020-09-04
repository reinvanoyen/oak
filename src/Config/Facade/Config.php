<?php

namespace Oak\Config\Facade;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Facade;

/**
 * Config facade for easy access to the repository.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Config extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return RepositoryInterface::class;
    }
}