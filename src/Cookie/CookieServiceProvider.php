<?php

namespace Oak\Cookie;

use Oak\Contracts\Config\RepositoryInterface;
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
        $app->singleton(CookieInterface::class, function($app) {

            $config = $app->get(RepositoryInterface::class);

            return new Cookie(
                $config->get('cookie.path', '/'),
                $config->get('cookie.secure', false),
                $config->get('cookie.http_only', true)
            );
        });
    }

    public function provides(): array
    {
        return [CookieInterface::class,];
    }
}