<?php

namespace Oak\Http\Routing;

use Oak\Contracts\Container\ContainerInterface;
use Oak\Contracts\Http\Middleware\MiddlewareRegisterInterface;
use Oak\Http\Middleware\CoreRequestHandler;
use Oak\Http\Middleware\MiddlewareStack;
use Oak\Http\Middleware\NextRequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
    /**
     * @var string $pattern
     */
    private $pattern;

    /**
     * @var string $controller
     */
    private $controller;

    /**
     * @var string $method
     */
    private $method;

    /**
     * @var array $params
     */
    private $params = [];

    /**
     * @var array $middleware
     */
    private $middleware = [];

    /**
     * Route constructor.
     * @param MiddlewareRegisterInterface $middlewareRegister
     * @param string $pattern
     * @param string $controller
     * @param string $method
     */
    public function __construct(MiddlewareRegisterInterface $middlewareRegister, string $pattern, string $controller, string $method)
    {
        $this->middlewareRegister = $middlewareRegister;
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @param array $middleware
     */
    public function middleware($middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function matches(string $path)
    {
        if(preg_match('@^('.$this->pattern.')$@', $path, $this->params)) {

            $this->params = array_filter($this->params, function ($key) {
                return (! is_int($key));
            }, ARRAY_FILTER_USE_KEY);

            return true;
        }

        return false;
    }

    /**
     * @param ContainerInterface $app
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function execute(ContainerInterface $app, ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $middleware = [];
        foreach ($this->middleware as $middlewareName) {
            foreach ($this->middlewareRegister->getMiddleware($middlewareName) as $middlewareClass) {
                $middleware[] = $app->get($middlewareClass);
            }
        }

        $controller = $app->getWith($this->controller, [
            'request' => $request,
            'response' => $response,
        ]);

        $middlewareStack = new MiddlewareStack($middleware);

        $coreRequestHandler = $app->getWith(CoreRequestHandler::class, [
            'controller' => $controller,
            'method' => $this->method,
            'params' => $this->params,
        ]);

        $nextRequestHandler = new NextRequestHandler($middlewareStack, $coreRequestHandler);

        $response = $nextRequestHandler->handle($request);

        return $response;
    }
}