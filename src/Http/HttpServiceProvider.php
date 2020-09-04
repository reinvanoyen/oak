<?php

namespace Oak\Http;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Http\ResponseEmitterInterface;
use Oak\Contracts\Http\Routing\RouterInterface;
use Oak\Contracts\Http\KernelInterface;
use Oak\Http\Routing\Router;
use Oak\ServiceProvider;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Service provider which provides the HTTP component.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class HttpServiceProvider extends ServiceProvider
{
    public function boot(ContainerInterface $app)
    {
        //
    }

    public function register(ContainerInterface $app)
    {
        $app->singleton(RouterInterface::class, Router::class);
        $app->singleton(KernelInterface::class, Kernel::class);
        $app->set(ResponseEmitterInterface::class, ResponseEmitter::class);
        $app->set(ResponseFactoryInterface::class, Psr17Factory::class);
        $app->set(StreamFactoryInterface::class, Psr17Factory::class);
        $app->set(ServerRequestInterface::class, function($app) {
            $psr17Factory = $app->get(ResponseFactoryInterface::class);
            return (new ServerRequestCreator(
                $psr17Factory, // ServerRequestFactory
                $psr17Factory, // UriFactory
                $psr17Factory, // UploadedFileFactory
                $psr17Factory  // StreamFactory
            ))->fromGlobals();
        });
    }
}
