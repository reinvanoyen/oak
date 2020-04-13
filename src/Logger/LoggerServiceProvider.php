<?php

namespace Oak\Logger;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Logger\LoggerInterface;
use Oak\Logger\Console\Logger;
use Oak\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)->registerCommand(Logger::class);
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->set(LoggerInterface::class, FileLogger::class);
        $app->whenAsksGive(
            FileLogger::class,
            'filename',
            $app->get(RepositoryInterface::class)
                ->get('logger.filename', 'logs/log.txt')
        );
    }
}