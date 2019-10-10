<?php

namespace Oak\Config\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class ClearCache extends Command
{
    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * ClearCache constructor.
     * @param FilesystemInterface $filesystem
     * @param ContainerInterface $app
     */
    public function __construct(FilesystemInterface $filesystem, ContainerInterface $app)
    {
        $this->filesystem = $filesystem;

        parent::__construct($app);
    }

    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('clear-cache')
            ->setDescription('Clear the config cache')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem->delete('cache/config.php');
        $output->writeLine('Config cache cleared');
    }
}