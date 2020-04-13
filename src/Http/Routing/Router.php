<?php

namespace Oak\Http\Routing;

use Nyholm\Psr7\Response;
use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Http\Middleware\MiddlewareRegisterInterface;
use Oak\Contracts\Http\Routing\RouterInterface;
use Oak\Http\Middleware\MiddlewareRegisterTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface, MiddlewareRegisterInterface
{
    use HasRoutesTrait;
    use MiddlewareRegisterTrait;

    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * Router constructor.
     * @param ContainerInterface $app
     * @param RepositoryInterface $config
     */
    public function __construct(ContainerInterface $app, RepositoryInterface $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $path = substr($request->getUri()->getPath(), strlen($this->config->get('http.path')));
        $path = ltrim($path, '/');

        $method = $request->getMethod();

        $routes = $this->getRoutesByMethod($method);

        foreach ($routes as $route) {
            if ($route->matches($path)) {
                $response = $route->execute($this->app, $request, new Response(200));
                return $response;
            }
        }

        return new Response(404);
    }
}