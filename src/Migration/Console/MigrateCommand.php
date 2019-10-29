<?php

namespace Oak\Migration\Console;

use Oak\Console\Command\Command;
use Oak\Migration\Migrator;

abstract class MigrateCommand extends Command
{
    /**
     * @var Migrator
     */
    private $migrator;

    /**
     * MigrateCommand constructor.
     * @param Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
     * @return Migrator
     */
    protected function getMigrator(): Migrator
    {
        return $this->migrator;
    }
}