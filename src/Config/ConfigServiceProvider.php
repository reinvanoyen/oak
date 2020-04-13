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
            $app->get(KernelInterface::class)
                ->registerCommand(Config::class)
            ;
        }

        // Load configuration variables
        $fs = $app->get(FilesystemInterface::class);
        $config = $app->get(RepositoryInterface::class);

        // Check if the cache file exists
        if ($fs->exists($app->getCachePath().'config.php')) {
            // It exists so we set all config variables from the cache
            $config->setAll(require $app->getCachePath().'config.php');
            return;
        }

        // Load all variables from all config files to the repository
        foreach ($fs->files($app->getConfigPath()) as $file) {
            $config->set(str_replace('.php', '', basename($file)), require $file);
        }

        // Add the config path to the config
        $config->set('app', [
            'env_path' => $app->getEnvPath(),
            'config_path' => $app->getConfigPath(),
            'cache_path' => $app->getCachePath(),
        ]);
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RepositoryInterface::class, Repository::class);
    }
}