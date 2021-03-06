<?php

namespace Oak\Logger\Console;

use Oak\Console\Command\Argument;
use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Logger\LoggerInterface;

class Log extends Command
{
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * Log constructor.
     * @param LoggerInterface $logger
     * @param ContainerInterface $app
     */
    public function __construct(LoggerInterface $logger, ContainerInterface $app)
    {
        $this->logger = $logger;

        parent::__construct($app);
    }

    /**
     * @param Signature $signature
     * @return Signature
     */
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('log')
            ->setDescription('Write a message to the log')
            ->addArgument(Argument::create('message')->setDescription('The message to log'))
            ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->log($input->getArgument('message'));
        $output->writeLine('Message logged', OutputInterface::TYPE_INFO);
    }
}