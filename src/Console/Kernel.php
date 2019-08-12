<?php

namespace Oak\Console;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

/**
 * Class Kernel
 * @package Oak\Console
 */
class Kernel extends Command implements KernelInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * An array holding registered commands
	 *
	 * @var array
	 */
	private $registeredCommands = [];

	/**
	 * Kernel constructor.
	 * @param ContainerInterface $app
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * Handle the incoming input
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	public function handle(InputInterface $input, OutputInterface $output)
	{
		foreach ($this->registeredCommands as $command) {
			if (is_string($command)) {
				$this->getSignature()->addSubCommand($this->container->get($command));
				continue;
			}

			$this->getSignature()->addSubCommand($command);
		}

		$this->run($input, $output);
	}

	/**
	 * Register a command
	 *
	 * @param $command
	 */
	public function registerCommand($command)
	{
		$this->registeredCommands[] = $command;
	}

	/**
	 * @param Signature $signature
	 * @return Signature
	 */
	protected function createSignature(Signature $signature): Signature
	{
		return $signature->setName('oak');
	}
}