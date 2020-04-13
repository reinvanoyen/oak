<?php

namespace Rein\Http\Routing;

use Oak\Contracts\Container\ContainerInterface;
use Rein\Http\Middleware\Contracts\MiddlewareRegisterInterface;
use Rein\Http\Middleware\MiddlewareRegisterTrait;
use Rein\Http\Routing\Contracts\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router implements RouterInterface, MiddlewareRegisterInterface
{
    use HasRoutesTrait;
    use MiddlewareRegisterTrait;

    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * Router constructor.
     * @param ContainerInterface $app
     */
    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request): Response
    {
        $path = substr($request->getPathInfo(), 1);
        $method = $request->getMethod();

        $routes = $this->getRoutesByMethod($method);

        foreach ($routes as $route) {
            if ($route->matches($path)) {
                return $route->execute($this->app, $request, new Response('', 200));
            }
        }

        return new Response('', 404);
    }
}