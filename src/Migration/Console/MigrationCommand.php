<?php

namespace Oak\Migration\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\MigrationManager;

class MigrationCommand extends Command
{
    /**
     * @var MigrationManager $manager
     */
    private $manager;

    /**
     * MigrationManagerCommand constructor.
     * @param MigrationManager $manager
     * @param ContainerInterface $app
     */
    public function __construct(MigrationManager $manager, ContainerInterface $app)
    {
        $this->manager = $manager;
        parent::__construct($app);
    }

    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('migration')
            ->addSubCommand(ListCommand::class)
            ->addSubCommand(MigrateCommand::class)
            ->addSubCommand(ResetCommand::class)
            ->addSubCommand(DowndateCommand::class)
            ->addSubCommand(UpdateCommand::class)
        ;
    }
}