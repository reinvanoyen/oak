<?php

namespace Oak\Scheduler;

use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Scheduler\JobInterface;
use Oak\Contracts\Scheduler\SchedulerInterface;
use Oak\Scheduler\Console\SchedulerCommand;
use Oak\ServiceProvider;

class SchedulerServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->set(SchedulerCommand::class, SchedulerCommand::class);
            $app->singleton(SchedulerInterface::class, Scheduler::class);
            $app->set(JobInterface::class, Job::class);
        }
    }

    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)
                ->registerCommand(SchedulerCommand::class)
            ;
        }
    }
}