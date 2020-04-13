<?php

namespace Oak\Session;

use Oak\Console\Facade\Console;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Session\SessionIdentifierInterface;
use Oak\ServiceProvider;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;

class SessionServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        $app->singleton(SessionIdentifierInterface::class, SessionIdentifier::class);

        $app->singleton(\SessionHandlerInterface::class, function() use ($app) {
            return new FileSessionHandler(
                $app->get(FilesystemInterface::class),
                $config = $app->get(RepositoryInterface::class)
                    ->get('session.path', $app->getCachePath().'sessions')
            );
        });

        $app->singleton(Session::class, function () use ($app) {
            return new Session(
                $app->get(\SessionHandlerInterface::class),
                $app->get(RepositoryInterface::class)
                    ->get('session.name', 'app')
            );
        });
    }

    public function boot(ContainerInterface $app)
    {
        // Register console command
        if ($app->isRunningInConsole()) {
            $app->get(KernelInterface::class)
                ->registerCommand(\Oak\Session\Console\Session::class)
            ;
        }
    }
}