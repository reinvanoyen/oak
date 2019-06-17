<?php

namespace app\cookie\facade;

use Oak\Contracts\Cookie\CookieInterface;
use Oak\Facade;

class Cookie extends Facade
{
	protected static function getContract(): string
	{
		return CookieInterface::class;
	}
}