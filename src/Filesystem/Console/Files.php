<?php

namespace Oak\Filesystem\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;

class Files extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('files')
            ->setDescription('List all files in a directory')
            ->addArgument(Argument::create('directory')->setDescription('Directory to list files from'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = \Oak\Filesystem\Facade\Filesystem::files($input->getArgument('directory'));

        foreach ($files as $file) {
            $output->writeLine(basename($file));
        }
    }
}