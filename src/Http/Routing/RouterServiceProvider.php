<?php

namespace Rein\Http\Routing;

use App\Controller\NewsController;
use App\Controller\PagesController;
use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;
use Rein\Http\Middleware\TrailingSlashMiddleware;
use Rein\Http\Routing\Contracts\RouterInterface;

class RouterServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        $router = $app->get(RouterInterface::class);

        $router->middleware('default', [
            TrailingSlashMiddleware::class,
        ]);

        $router->get('', PagesController::class, 'index')
            ->middleware(['default'])
        ;

        $router->get('(?<slug>.*)/(?<newsSlug>.*)/', NewsController::class, 'view')
            ->middleware(['default'])
        ;

        $router->get('(?<slug>.*)', PagesController::class, 'view')
            ->middleware(['default'])
        ;
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RouterInterface::class, Router::class);
    }
}