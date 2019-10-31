<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Migrate extends MigrateCommand
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('migrate')
            ->setDescription('Migrates to the latest version')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getMigrator()->migrate();
        $output->writeLine('Migration complete', OutputInterface::TYPE_INFO);
    }
}