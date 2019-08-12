<?php

namespace Oak\Console\Command;

use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

abstract class Command
{
	/**
	 * The signature of the command
	 *
	 * @var Signature
	 */
	private $signature;

	/**
	 * Stores if the command was created
	 *
	 * @var bool
	 */
	private $created = false;

	/**
	 * Creates the signature of the command
	 *
	 * @param Signature $signature
	 * @return Signature
	 */
	abstract protected function createSignature(Signature $signature): Signature;

	/**
	 * Gets the name of the command
	 *
	 * @return string
	 * @throws \Exception
	 */
	final public function getName(): string
	{
		$this->make();

		if (! $this->signature->hasName()) {
			throw new \Exception('Command should have a name');
		}

		return $this->signature->getName();
	}

	/**
	 * Gets the description of the command
	 *
	 * @return string
	 * @throws \Exception
	 */
	final public function getDescription(): string
	{
		$this->make();

		return $this->signature->getDescription();
	}

	/**
	 * Gets the signature of the command
	 *
	 * @return Signature
	 */
	final public function getSignature(): Signature
	{
		$this->make();
		return $this->signature;
	}

	/**
	 * Creates the signature of the command
	 *
	 * @throws \Exception
	 */
	final private function make()
	{
		if ($this->created) {
			return;
		}

		$signature = new Signature();
		$signature->addOption(Option::create('help', 'h')->setDescription('Display this help message'));
		$this->signature = $this->createSignature($signature);

		if (! $this->signature->hasName()) {
			throw new \Exception('Command should have a name');
		}

		$this->created = true;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->outputHelpMessage($output);
	}

	/**
	 * Runs the command
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	final public function run(InputInterface $input, OutputInterface $output)
	{
		$input->setSignature($this->getSignature());

		$showHelpMessage = (bool) $input->getOption('help');

		if ($showHelpMessage && ! $input->hasSubCommand()) {
			$this->outputHelpMessage($output);
			return;
		}

		if ($input->hasSubCommand()) {
			$command = $this->signature->getSubCommand($input->getSubCommand());
			$command->run($input, $output);
			return;
		}

		$input->validate();

		$this->execute($input, $output);
	}

	/**
	 * Output an auto-generated help message
	 *
	 * @param OutputInterface $output
	 */
	public function outputHelpMessage(OutputInterface $output)
	{
		$output->write('
            _   
           | |  
 __   __,  | |  
/  \_/  |  |/_) 
\__/ \_/|_/| \_/
		');

		if ($this->getDescription()) {
			$output->writeLine($this->getName().':', OutputInterface::TYPE_WARNING);
			$output->writeLine(' '.$this->getDescription());
		}

		$output->newline();

		$commands = $this->signature->getSubCommands();
		$arguments = $this->signature->getArguments();
		$options = $this->signature->getOptions();

		$output->writeLine('Usage:', OutputInterface::TYPE_WARNING);

		$output->write(' '.$this->getName());
		if (count($commands)) {
			$output->write(' [command]');
		}

		if (count($arguments)) {
			foreach ($arguments as $argument) {
				$output->write(' <'.$argument->getName().'>');
			}
		}

		if (count($options)) {
			$output->write(' [options]');
		}

		$output->newline();
		$output->newline();

		// Output available commands
		if (count($commands)) {
			$output->writeLine('Available commands:', OutputInterface::TYPE_WARNING);

			foreach ($commands as $command) {
				$output->write(' '.str_pad($command->getName(), 20), OutputInterface::TYPE_INFO);
				$output->write($command->getDescription(), OutputInterface::TYPE_INFO);
				$output->newline();

				foreach ($command->getSignature()->getSubCommands() as $subCommand) {
					$output->write('   '.str_pad($subCommand->getName(), 18), OutputInterface::TYPE_PLAIN);
					$output->write($subCommand->getDescription());
					$output->newline();
				}
			}

			$output->newline();
		}

		// Output available arguments
		if (count($arguments)) {
			$output->writeLine('Arguments:', OutputInterface::TYPE_WARNING);

			foreach ($arguments as $argument) {
				$output->write(' '.str_pad($argument->getName(), 20), OutputInterface::TYPE_INFO);
				$output->write($argument->getDescription());
				$output->newline();
			}

			$output->newline();
		}

		// Output available options
		if (count($options)) {
			$output->writeLine('Options:', OutputInterface::TYPE_WARNING);

			foreach ($options as $option) {
				$output->write(' '.str_pad('-'.$option->getAlias().', --'.$option->getName(), 20), OutputInterface::TYPE_INFO);
				$output->write($option->getDescription());
				$output->newline();
			}

			$output->newline();
		}
	}
}