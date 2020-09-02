<?php

namespace Oak\Database;

use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        $app->set(ConnectionManager::class, ConnectionManager::class);
    }

    public function boot(ContainerInterface $app)
    {
        //
    }
}