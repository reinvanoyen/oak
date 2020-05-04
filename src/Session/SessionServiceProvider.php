<?php

namespace Oak\Session;

use Oak\ServiceProvider;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Console\KernelInterface;
use Oak\Contracts\Session\SessionIdentifierInterface;
use Oak\Contracts\Container\ContainerInterface;

class SessionServiceProvider extends ServiceProvider
{
    public function register(ContainerInterface $app)
    {
        $config = $app->get(RepositoryInterface::class);

        $app->singleton(\SessionHandlerInterface::class, $config->get('session.handler', FileSessionHandler::class));
        $app->singleton(Session::class, Session::class);
        $app->singleton(SessionIdentifierInterface::class, SessionIdentifier::class);

        $app->whenAsksGive(FileSessionHandler::class, 'path', $config->get('session.path', 'sessions'));
        $app->whenAsksGive(Session::class, 'name', $config->get('session.name', 'app'));
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