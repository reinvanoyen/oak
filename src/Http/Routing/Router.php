<?php

namespace Oak\Http\Routing;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Http\Middleware\MiddlewareRegisterInterface;
use Oak\Contracts\Http\Routing\RouterInterface;
use Oak\Http\Middleware\MiddlewareRegisterTrait;
use Psr\Http\Message\ResponseFactoryInterface;
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
     * @var ResponseFactoryInterface $responseFactory
     */
    private $responseFactory;

    /**
     * Router constructor.
     * @param ContainerInterface $app
     * @param RepositoryInterface $config
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ContainerInterface $app, RepositoryInterface $config, ResponseFactoryInterface $responseFactory)
    {
        $this->app = $app;
        $this->config = $config;
        $this->responseFactory = $responseFactory;
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
                return $route->execute($this->app, $request, $this->responseFactory->createResponse(200)
                    ->withHeader('Content-Type', 'text/html')
                );
            }
        }

        return $this->responseFactory->createResponse(404);
    }
}
