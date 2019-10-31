<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Command;
use Oak\Contracts\Container\ContainerInterface;
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
    public function __construct(Migrator $migrator, ContainerInterface $app)
    {
        $this->migrator = $migrator;
        parent::__construct($app);
    }

    /**
     * @return Migrator
     */
    protected function getMigrator(): Migrator
    {
        return $this->migrator;
    }
}