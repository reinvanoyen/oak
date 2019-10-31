<?php

namespace Oak\Migration\Console\Manager;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\MigrationManager;

class MigrateAllCommand extends Command
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
            ->setName('migrate-all')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->manager->getMigrators() as $migrator) {
            $output->writeLine('Start '.$migrator->getName().' migrator ('.$migrator->getVersion().'/'.$migrator->getMaxVersion().')', OutputInterface::TYPE_INFO);
            $migrator->migrate();
        }
    }
}