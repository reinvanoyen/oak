<?php

namespace Oak\Session\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Session\Session;

class GarbageCollect extends Command
{
    /**
     * @var Session $session
     */
    private $session;

    /**
     * GarbageCollect constructor.
     * @param Session $session
     * @param ContainerInterface $app
     */
    public function __construct(Session $session, ContainerInterface $app)
    {
        $this->session = $session;

        parent::__construct($app);
    }

    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('garbage-collect')
            ->setDescription('Garbage collect all sessions')
            ->addArgument(Argument::create('maxLifetime')->setDescription('Max lifetime in seconds'))
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->session->getHandler()
            ->gc((int) $input->getArgument('maxLifetime'));

        $output->writeLine('Sessions successfully garbage collected');
    }
}