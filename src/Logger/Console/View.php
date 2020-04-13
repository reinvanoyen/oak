<?php

namespace Oak\Logger\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class View extends Command
{
    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * View constructor.
     * @param RepositoryInterface $config
     * @param FilesystemInterface $filesystem
     * @param ContainerInterface $app
     */
    public function __construct(RepositoryInterface $config, FilesystemInterface $filesystem, ContainerInterface $app)
    {
        $this->config = $config;
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
            ->setName('view')
            ->setDescription('View the log')
            ->addArgument(
                Argument::create('lines')
                    ->setDescription('Amount of lines to display')
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = $this->filesystem->get($this->config->get('logger.filename', 'logs/log.txt'));

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