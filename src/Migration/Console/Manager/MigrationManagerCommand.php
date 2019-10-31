<?php

namespace Oak\Migration\Console\Manager;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;

class MigrationManagerCommand extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('migration')
            ->addSubCommand(MigrateAllCommand::class)
            ->addSubCommand(ListCommand::class)
            ->addSubCommand(StatusCommand::class)
        ;
    }
}