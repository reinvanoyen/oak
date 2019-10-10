<?php

namespace Oak\Session\Facade;

use Oak\Facade;

class Session extends Facade
{
    protected static function getContract(): string
    {
        return \Oak\Session\Session::class;
    }
}