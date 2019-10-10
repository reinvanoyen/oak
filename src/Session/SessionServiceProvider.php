<?php

namespace Oak\Session;

use Oak\Config\Facade\Config;
use Oak\Console\Facade\Console;
use Oak\Contracts\Cookie\CookieInterface;
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
            return new FileSessionHandler($app->get(FilesystemInterface::class), Config::get('session.path', 'cache/sessions'));
        });

        $app->singleton(Session::class, function () use ($app) {
            return new Session($app->get(\SessionHandlerInterface::class), Config::get('session.name', 'oak_app'));
        });
    }

    public function boot(ContainerInterface $app)
    {
        $session = $app->get(Session::class);
        $cookie = $app->get(CookieInterface::class);

        // Garbage collection lottery
        if (rand(0, 1000) === 1) {
            $session->getHandler()->gc(1000);
        }

        // Set session cookie
        $cookieName = Config::get('session.cookie_prefix', 'session').'_'.$session->getName();

        if (! $cookie->has($cookieName)) {

            // No session id found, so we generate one
            $sessionId = $app->get(SessionIdentifierInterface::class)->generate(Config::get('session.identifier_length', 40));

            // Set the id in the cookie
            $cookie->set($cookieName, $sessionId);
        }

        $session->setId($cookie->get($cookieName));

        // Register console command
        if ($app->isRunningInConsole()) {
            Console::registerCommand(\Oak\Session\Console\Session::class);
        }
    }
}