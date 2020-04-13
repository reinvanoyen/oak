<?php

namespace Oak\Cookie\Facade;

use Oak\Contracts\Cookie\CookieInterface;
use Oak\Facade;

class Cookie extends Facade
{
    /**
     * @return string
     */
    protected static function getContract(): string
    {
        return CookieInterface::class;
    }
}