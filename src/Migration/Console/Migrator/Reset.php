<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

use Oak\Console\Command\Signature;

class Reset extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('reset')
            ->setDescription('Undo all revisions')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getMigrator()->reset();
        $output->writeLine('Reset complete', OutputInterface::TYPE_INFO);
    }
}