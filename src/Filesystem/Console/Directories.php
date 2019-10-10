<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Directories extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('directories')
            ->setDescription('List all directories in a directory')
            ->addArgument(Argument::create('directory')->setDescription('Directory to list directories from'))
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directories = \Oak\Filesystem\Facade\Filesystem::directories($input->getArgument('directory'));

        foreach ($directories as $directory) {
            $output->writeLine(basename($directory));
        }
    }
}