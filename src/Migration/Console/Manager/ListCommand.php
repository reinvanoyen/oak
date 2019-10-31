<?php

namespace Oak\Migration\Console\Manager;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\MigrationManager;

class ListCommand extends Command
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
        foreach ($this->manager->getMigrators() as $migrator) {

            $signature->addSubCommand(
                $this->app->getWith(\Oak\Migration\Console\Migrator\Command::class, [
                    'name' => $migrator->getName(),
                    'migrator' => $migrator,
                ])
            );
        }

        return $signature
            ->setName('list')
            ;
    }
}