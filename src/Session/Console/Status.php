<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Filesystem\Facade\Filesystem;

class Status extends Command
{
	protected function createSignature(Signature $signature): Signature
	{
		return $signature
			->setName('status')
			->setDescription('Show a status for the session system')
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$sessionFiles = Filesystem::files('cache/sessions');

		$output->writeLine('SESSION STATUS');
		$output->writeLine('Active sessions: '.count($sessionFiles), OutputInterface::TYPE_INFO);
	}
}