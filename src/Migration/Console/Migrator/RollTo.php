<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class RollTo extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('rollto')
            ->setDescription('Rolls to a specific version number')
            ->addArgument(Argument::create('version')->setDescription('The version number to roll to'))
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getMigrator()->rollTo((int) $input->getArgument('version'));
        $output->writeLine('Rollto complete', OutputInterface::TYPE_INFO);
    }
}