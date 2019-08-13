<?php

namespace Oak\Session;

use Oak\Contracts\Session\SessionIdentifierInterface;
use Oak\ServiceProvider;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Filesystem\FilesystemInterface;
use Oak\Cookie\Facade\Cookie;

class SessionServiceProvider extends ServiceProvider
{
	public function register(ContainerInterface $app)
	{
		$app->singleton(SessionIdentifierInterface::class, SessionIdentifier::class);

		$app->singleton(\SessionHandlerInterface::class, function() use ($app) {
			return new FileSessionHandler($app->get(FilesystemInterface::class), 'cache/sessions');
		});

		$app->singleton(Session::class, function () use ($app) {
			return new Session($app->get(\SessionHandlerInterface::class), 'oak_app');
		});
	}

	public function boot(ContainerInterface $app)
	{
		$session = $app->get(Session::class);

		// Garbage collection lottery
		if (rand(0, 1000) === 1) {
			$session->getHandler()->gc(1000);
		}

		$cookieName = 'session_'.$session->getName();

		if (! Cookie::has($cookieName)) {

			// No session id found, so we generate one
			$sessionId = $app->get(SessionIdentifierInterface::class)->generate(40);

			// Set the id in the cookie
			Cookie::set($cookieName, $sessionId);
		}

		$session->setId(Cookie::get($cookieName));
	}
}