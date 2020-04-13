<?php

namespace Rein\Http\Middleware;

trait MiddlewareRegisterTrait
{
    /**
     * @var array $middlewares
     */
    private $middlewares = [];

    /**
     * @param string $name
     * @param array $middlewares
     */
    public function middleware(string $name, array $middlewares = [])
    {
        if (! isset($this->middlewares[$name])) {
            $this->middlewares[$name] = $middlewares;
        }
    }

    /**
     * @param string $name
     * @return array|mixed
     */
    public function getMiddleware(string $name): array
    {
        return $this->middlewares[$name] ?? [];
    }
}