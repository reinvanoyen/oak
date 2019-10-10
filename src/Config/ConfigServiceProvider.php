<?php

namespace Oak\Config;

use Oak\Config\Console\Config;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        // Register Config command
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)->registerCommand(Config::class);
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RepositoryInterface::class, function($app) {

            $fs = $app->get(FilesystemInterface::class);

            // Check if the cache file exists
            if ($fs->exists('cache/config.php')) {

                // It exists so we give back the config with all data from the cache
                return new Repository(require 'cache/config.php');
            }

            $files = $fs->files('config');

            $repository = new Repository([]);

            foreach ($files as $file) {
                $repository->set(str_replace('.php', '', basename($file)), require $file);
            }

            return $repository;
        });
    }
}