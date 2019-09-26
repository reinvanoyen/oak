<?php

namespace Oak\Config;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    protected $isLazy = true;

    public function boot(ContainerInterface $app)
    {
        $config = $app->get(RepositoryInterface::class);
        $fs = $app->get(FilesystemInterface::class);
        $files = $fs->files('config');

        foreach ($files as $file) {
            $config->set(str_replace('.php', '', basename($file)), require $file);
        }
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RepositoryInterface::class, Repository::class);
    }

    public function provides(): array
    {
        return [RepositoryInterface::class,];
    }
}