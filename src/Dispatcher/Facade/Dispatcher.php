<?php

namespace Oak\Dispatcher\Facade;

use Oak\Contracts\Dispatcher\DispatcherInterface;
use Oak\Facade;

class Dispatcher extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return DispatcherInterface::class;
    }
}