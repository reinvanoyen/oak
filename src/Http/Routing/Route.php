<?php

namespace Rein\Http\Routing;

use Oak\Contracts\Container\ContainerInterface;
use Rein\Http\Middleware\Contracts\MiddlewareRegisterInterface;
use Rein\Http\Middleware\MiddlewareStackTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Route
{
    use MiddlewareStackTrait;

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
     * @param string $path
     * @return bool
     */
    public function matches(string $path)
    {
        if(preg_match( '@^('.$this->pattern.')$@', $path, $this->params)) {

            $this->params = array_filter($this->params, function ($key) {
                return (! is_int($key));
            }, ARRAY_FILTER_USE_KEY);

            return true;
        }

        return false;
    }

    /**
     * @param ContainerInterface $app
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function execute(ContainerInterface $app, Request $request, Response $response): Response
    {
        return $this->runMiddlewareStack($app, $request, $response, function ($request, $response) use ($app) {

            $controller = $app->getWith($this->controller, [
                'request' => $request,
                'response' => $response,
            ]);

            $output = call_user_func_array([$controller, $this->method], $this->params);

            if ($output instanceof Response) {
                return $output;
            }

            $response->setContent($output);

            return $response;
        });
    }
}