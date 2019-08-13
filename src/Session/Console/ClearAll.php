<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Filesystem\Facade\Filesystem;

class ClearAll extends Command
{
	protected function createSignature(Signature $signature): Signature
	{
		return $signature
			->setName('clear-all')
			->setDescription('Clear all sessions')
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$sessionHandler = \Oak\Session\Facade\Session::getHandler();

		$sessions = Filesystem::files('cache/sessions');

		foreach ($sessions as $session) {
			$sessionId = basename($session);
			$sessionHandler->destroy($sessionId);
			$output->writeLine('Clearing session '.$sessionId);
		}

		$output->writeLine('Sessions cleared!', OutputInterface::TYPE_INFO);
	}
}