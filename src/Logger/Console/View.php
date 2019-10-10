<?php

namespace Oak\Logger\Console;

use Oak\Config\Facade\Config;
use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Filesystem\Facade\Filesystem;

class View extends Command
{
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('view')
            ->setDescription('View the log')
            ->addArgument(Argument::create('lines')->setDescription('Amount of lines to display'))
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = Filesystem::get(Config::get('logger.filename', 'cache/logs/log.txt'));

        $linesArray = explode("\n", $lines);
        $linesArray = array_filter($linesArray, function($value) {
            return ($value);
        });

        $lineAmount = (int) $input->getArgument('lines');
        $linesArray = array_slice($linesArray, -$lineAmount, $lineAmount);

        foreach ($linesArray as $line) {
            $output->writeLine($line);
        }
    }
}