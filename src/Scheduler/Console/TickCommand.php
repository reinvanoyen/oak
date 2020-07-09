<?php

namespace Oak\Scheduler\Console;

use Oak\Console\Command\Command;
use Oak\Console\Command\Signature;
use Oak\Contracts\Console\InputInterface;
use Oak\Contracts\Console\OutputInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Scheduler\SchedulerInterface;

class TickCommand extends Command
{
    /**
     * @var SchedulerInterface $scheduler
     */
    private $scheduler;

    /**
     * SchedulerCommand constructor.
     * @param SchedulerInterface $scheduler
     * @param ContainerInterface $app
     */
    public function __construct(SchedulerInterface $scheduler, ContainerInterface $app)
    {
        $this->scheduler = $scheduler;

        parent::__construct($app);
    }

    /**
     * @param Signature $signature
     * @return Signature
     */
    protected function createSignature(Signature $signature): Signature
    {
        return $signature
            ->setName('tick')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        while (true) {
            $this->scheduler->runSchedule($output);
            sleep(60);
        }
    }
}