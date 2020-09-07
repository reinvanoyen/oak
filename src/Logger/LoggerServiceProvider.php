<?php

namespace Oak\Logger;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Contracts\Logger\LoggerInterface;
use Oak\Filesystem\DiskManager;
use Oak\Logger\Console\Logger;
use Oak\ServiceProvider;

/**
 * Service provider for the Logger component.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class LoggerServiceProvider extends ServiceProvider
{
    protected $isLazy = true;
    
    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)->registerCommand(Logger::class);
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->set(LoggerFactory::class, LoggerFactory::class);
        $app->set(ChannelManager::class, ChannelManager::class);
        $app->set(LoggerInterface::class, function($app) {
            return $app->get(ChannelManager::class)
                ->channel('default');
        });
    }
    
    public function provides(): array
    {
        return [LoggerFactory::class, ChannelManager::class, LoggerInterface::class,];
    }
}