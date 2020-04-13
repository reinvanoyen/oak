<?php

namespace Oak\Session\Console;

use Oak\Config\Facade\Config;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Filesystem\Facade\Filesystem;

class Status extends Command
{
    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * Status constructor.
     * @param FilesystemInterface $filesystem
     * @param ContainerInterface $app
     */
    public function __construct(FilesystemInterface $filesystem, RepositoryInterface $config, ContainerInterface $app)
    {
        $this->filesystem = $filesystem;
        $this->config = $config;

        parent::__construct($app);
    }

    /**
     * @param Signature $signature
     * @return Signature
     */
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('status')
            ->setDescription('Show a status for the session system')
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sessionFiles = $this->filesystem->files($this->config->get('session.path', 'sessions'));

        $output->writeLine('SESSION STATUS');
        $output->writeLine('Active sessions: '.count($sessionFiles), OutputInterface::TYPE_INFO);
    }
}