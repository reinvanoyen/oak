<?php

namespace Oak\Console;

use Oak\Application;
use Oak\Console\Command\Option;
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
     * An array holding registered commands
     *
     * @var array
     */
    private $registeredCommands = [];

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
                $this->getSignature()->addSubCommand($this->app->get($command));
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
        return $signature->setName('oak')
            ->addOption(Option::create('version', 'v')->setDescription('Display the version of Oak framework'))
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->showLogo($output);
        if ($input->getOption('version')) {
            $output->newline();
            $output->writeLine('Oak framework version '.Application::VERSION, OutputInterface::TYPE_INFO);
            $output->writeLine('By Rein Van Oyen');
            $output->newline();
            $output->writeLine('More information, feedback or need help?');
            $output->writeLine('https://github.com/reinvanoyen/oak');
            return;
        }

        parent::execute($input, $output);
    }

    /**
     * @param OutputInterface $output
     */
    private function showLogo(OutputInterface $output)
    {
        $output->write(file_get_contents(__DIR__.'/../Resources/ascii-logo.txt'));
        $output->newline();
    }
}