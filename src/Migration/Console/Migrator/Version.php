<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Version extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('version')
            ->setDescription('Prints the current version')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLine($this->getMigrator()->getVersion());
    }
}