<?php

namespace Oak\Filesystem;

use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Filesystem\Console\Filesystem;
use Oak\ServiceProvider;

/**
 * Class FilesystemServiceProvider
 * @package Oak\Filesystem
 */
class FilesystemServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)
                ->registerCommand(Filesystem::class)
            ;
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->set(DiskManager::class, DiskManager::class);
        $app->set(FilesystemInterface::class, LocalFilesystem::class);
    }
}