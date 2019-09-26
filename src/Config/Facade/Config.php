<?php

namespace Oak\Config\Facade;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Facade;

class Config extends Facade
{
    protected static function getContract(): string
    {
        return RepositoryInterface::class;
    }
}