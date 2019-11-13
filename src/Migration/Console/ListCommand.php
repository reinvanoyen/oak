<?php

namespace Oak\Migration\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
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
        return $signature
            ->setName('list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (! count($this->manager->getMigrators())) {
            $output->writeLine('No migrators registered', OutputInterface::TYPE_ERROR);
            return;
        }

        foreach ($this->manager->getMigrators() as $migrator) {
            $output->writeLine($migrator->getName().' ('.$migrator->getVersion().'/'.$migrator->getMaxVersion().')');
        }
    }
}