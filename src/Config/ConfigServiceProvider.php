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
    protected $isLazy = true;

    public function boot(ContainerInterface $app)
    {
        // Register Config command
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)
                ->registerCommand(Config::class)
            ;
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RepositoryInterface::class, function($app) {
            
            return $app->getWith(Repository::class, [
                'configPath' => $app->getConfigPath(),
                'cachePath' => $app->getCachePath(),
                'envPath' => $app->getEnvPath(),
            ]);
        });
    }

    public function provides(): array
    {
        return [RepositoryInterface::class,];
    }
}
