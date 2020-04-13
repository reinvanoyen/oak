<?php

namespace Oak\Config\Facade;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Facade;

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