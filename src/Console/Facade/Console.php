<?php

namespace Oak\Console\Facade;

use Oak\Contracts\Console\KernelInterface;
use Oak\Facade;

class Console extends Facade
{
    protected static function getContract(): string
    {
        return KernelInterface::class;
    }
}