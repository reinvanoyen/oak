<?php

namespace Oak\Migration\Console\Migrator;

use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Migration\Migrator;

class Command extends MigrateCommand
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * Command constructor.
     * @param string $name
     * @param Migrator $migrator
     */
    public function __construct(string $name, Migrator $migrator, ContainerInterface $app)
    {
        $this->name = $name;
        parent::__construct($migrator, $app);
    }

    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName($this->name)
            ->setDescription($this->name.' migrator')
            ->addSubCommand(new Migrate($this->getMigrator(), $this->app))
            ->addSubCommand(new RollTo($this->getMigrator(), $this->app))
            ->addSubCommand(new Update($this->getMigrator(), $this->app))
            ->addSubCommand(new Downdate($this->getMigrator(), $this->app))
            ->addSubCommand(new Reset($this->getMigrator(), $this->app))
            ->addSubCommand(new Version($this->getMigrator(), $this->app))
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->newline();
        $output->writeLine('Migrator status:', OutputInterface::TYPE_WARNING);

        $version = $this->getMigrator()->getVersion();
        $max = $this->getMigrator()->getMaxVersion();

        if ($version < $max) {
            $output->writeLine(' Not up-to-date', OutputInterface::TYPE_ERROR);
        } else {
            $output->writeLine(' Up-to-date', OutputInterface::TYPE_INFO);
        }

        $output->write(' Currently on version ');
        $output->write($this->getMigrator()->getVersion(), OutputInterface::TYPE_INFO);
        $output->write(' of ');
        $output->write($this->getMigrator()->getMaxVersion(), OutputInterface::TYPE_INFO);

        $output->newline();
        $output->newline();

        parent::execute($input, $output);
    }
}