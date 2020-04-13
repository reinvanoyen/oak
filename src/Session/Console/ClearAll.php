<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Filesystem\Facade\Filesystem;
use Oak\Session\Session;

class ClearAll extends Command
{
    /**
     * @var Session $session
     */
    private $session;

    /**
     * @var FilesystemInterface $filesystem
     */
    private $filesystem;

    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * ClearAll constructor.
     * @param Session $session
     * @param ContainerInterface $app
     */
    public function __construct(Session $session, FilesystemInterface $filesystem, RepositoryInterface $config, ContainerInterface $app)
    {
        $this->session = $session;
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
            ->setName('clear-all')
            ->setDescription('Clear all sessions')
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sessionHandler = $this->session->getHandler();

        $sessions = $this->filesystem->files(
            $this->config->get('session.path', 'sessions')
        );

        foreach ($sessions as $session) {
            $sessionId = basename($session);
            $sessionHandler->destroy($sessionId);
            $output->writeLine('Clearing session '.$sessionId);
        }

        $output->writeLine('Sessions cleared!', OutputInterface::TYPE_INFO);
    }
}