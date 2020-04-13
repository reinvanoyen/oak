<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class Files extends Command
{
    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * Files constructor.
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
            ->setName('files')
            ->setDescription('List all files in a directory')
            ->addArgument(Argument::create('directory')->setDescription('Directory to list files from'))
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $this->filesystem->files($input->getArgument('directory'));

        foreach ($files as $file) {
            $output->writeLine(basename($file));
        }
    }
}