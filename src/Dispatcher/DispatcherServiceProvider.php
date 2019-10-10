<?php

namespace Oak\Dispatcher;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Dispatcher\DispatcherInterface;
use Oak\ServiceProvider;

class DispatcherServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        //
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(DispatcherInterface::class, Dispatcher::class);
    }
}