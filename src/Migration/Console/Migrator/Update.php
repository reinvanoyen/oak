<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Update extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('update')
            ->setDescription('Update to the next version')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getMigrator()->update();
        $output->writeLine('Update complete', OutputInterface::TYPE_INFO);
    }
}