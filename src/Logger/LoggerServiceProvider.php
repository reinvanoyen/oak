<?php

namespace Oak\Logger;

use Oak\Config\Facade\Config;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
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
        $app->set(LoggerInterface::class, function() use ($app) {

            return new FileLogger(
                Config::get('logger.filename', 'cache/logs/log.txt'),
                $app->get(FilesystemInterface::class)
            );
        });
    }
}