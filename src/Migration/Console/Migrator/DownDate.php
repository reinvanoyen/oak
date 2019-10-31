<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Downdate extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('downdate')
            ->setDescription('Downdate to the previous version')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getMigrator()->downdate();
        $output->writeLine('Downdate complete', OutputInterface::TYPE_INFO);
    }
}