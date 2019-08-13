<?php

namespace Oak\Logger\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Log extends Command
{
	protected function createSignature(Signature $signature): Signature
	{
		return $signature
			->setName('log')
			->setDescription('Write a message to the log')
			->addArgument(Argument::create('message')->setDescription('The message to log'))
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		Logger::log($input->getArgument('message'));

		$output->writeLine('Message logged', OutputInterface::TYPE_INFO);
	}
}