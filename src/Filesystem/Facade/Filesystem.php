<?php

namespace app\filesystem\facade;

use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Facade;

class Filesystem extends Facade
{
	protected static function getContract(): string
	{
		return FilesystemInterface::class;
	}
}