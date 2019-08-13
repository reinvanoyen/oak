<?php

namespace Oak\Cookie;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Cookie\CookieInterface;
use Oak\ServiceProvider;

class CookieServiceProvider extends ServiceProvider
{
	protected $isLazy = true;

	public function boot(ContainerInterface $app)
	{
		//
	}

	public function register(ContainerInterface $app)
	{
		$app->singleton(CookieInterface::class, function() use ($app) {
			return new Cookie('/');
		});
	}

	public function provides(): array
	{
		return [CookieInterface::class,];
	}
}