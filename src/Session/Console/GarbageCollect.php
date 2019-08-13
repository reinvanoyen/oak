<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class GarbageCollect extends Command
{
	protected function createSignature(Signature $signature): Signature
	{
		return $signature
			->setName('garbage-collect')
			->setDescription('Garbage collect all sessions')
			->addArgument(Argument::create('maxLifetime')->setDescription('Max lifetime in seconds'))
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$sessionHandler = \Oak\Session\Facade\Session::getHandler();
		$sessionHandler->gc((int) $input->getArgument('maxLifetime'));

		$output->writeLine('Sessions successfully garbage collected');
	}
}