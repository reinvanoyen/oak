<?php

namespace Oak\Migration\Console;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Migration\Migrator;

class Command extends MigrateCommand
{
    private $name;

    public function __construct(string $name, Migrator $migrator)
    {
        $this->name = $name;
        parent::__construct($migrator);
    }

    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName($this->name)
            ->setDescription('Migration CLI tool')
            ->addSubCommand(new Migrate($this->getMigrator()))
            ->addSubCommand(new RollTo($this->getMigrator()))
            ->addSubCommand(new Update($this->getMigrator()))
            ->addSubCommand(new Downdate($this->getMigrator()))
            ->addSubCommand(new Reset($this->getMigrator()))
            ->addSubCommand(new Version($this->getMigrator()))
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->newline();
        $output->writeLine('Migrator status:', OutputInterface::TYPE_WARNING);

        $version = $this->getMigrator()->getVersion();
        $max = $this->getMigrator()->getMaxVersion();

        if ($version < $max) {
            $output->writeLine(' Not up-to-date', OutputInterface::TYPE_ERROR);
        } else {
            $output->writeLine(' Up-to-date', OutputInterface::TYPE_INFO);
        }

        $output->write(' Currently on version ');
        $output->write($this->getMigrator()->getVersion(), OutputInterface::TYPE_INFO);
        $output->write(' of ');
        $output->write($this->getMigrator()->getMaxVersion(), OutputInterface::TYPE_INFO);

        $output->newline();
        $output->newline();

        parent::execute($input, $output);
    }
}