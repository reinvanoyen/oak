<?php

namespace Oak\Migration\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Option;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\MigrationManager;

class DowndateCommand extends Command
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
            ->setName('downdate')
            ->addOption(
                Option::create('migrator', 'm')
                    ->setDescription('Specify a specific migrator')
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (array_reverse($this->manager->getMigrators()) as $migrator) {

            if (
                ! ($migratorName = $input->getOption('migrator')) ||
                $migrator->getName() === $migratorName
            ) {
                $migrator->downdate();

                if ($migratorName) {
                    break;
                }
            }
        }
    }
}
