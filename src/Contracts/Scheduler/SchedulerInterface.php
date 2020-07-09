<?php

namespace Oak\Contracts\Scheduler;

use Oak\Contracts\Console\OutputInterface;

interface SchedulerInterface
{
    /**
     * @param string $command
     * @return JobInterface
     */
    public function run(string $command): JobInterface;

    /**
     * @param JobInterface $job
     * @return mixed
     */
    public function isDue(JobInterface $job);

    /**
     * @param OutputInterface $output
     * @return mixed
     */
    public function runSchedule(OutputInterface $output);
}