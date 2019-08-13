<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class Filesystem extends Command
{
	protected function createSignature(Signature $signature): Signature
	{
		return $signature
			->setName('fs')
			->addSubCommand(new Directories())
			->addSubCommand(new Files())
		;
	}
}