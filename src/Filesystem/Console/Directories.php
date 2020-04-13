<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class Directories extends Command
{
    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * Directories constructor.
     * @param FilesystemInterface $filesystem
     * @param ContainerInterface $app
     */
    public function __construct(FilesystemInterface $filesystem, ContainerInterface $app)
    {
        $this->filesystem = $filesystem;

        parent::__construct($app);
    }

    /**
     * @param Signature $signature
     * @return Signature
     */
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('directories')
            ->setDescription('List all directories in a directory')
            ->addArgument(Argument::create('directory')->setDescription('Directory to list directories from'))
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directories = $this->filesystem->directories($input->getArgument('directory'));

        foreach ($directories as $directory) {
            $output->writeLine(basename($directory));
        }
    }
}