<?php

namespace Oak\Http\Middleware;

trait MiddlewareRegisterTrait
{
    /**
     * @var array $middlewareGroups
     */
    private $middlewareGroups = [];

    /**
     * Set middlewares for group name
     *
     * @param string $name
     * @param array $middlewares
     */
    public function middleware(string $name, array $middlewares = [])
    {
        if (! isset($this->middlewares[$name])) {
            $this->middlewareGroups[$name] = $middlewares;
        }
    }

    /**
     * Get middlewares by group name
     *
     * @param string $name
     * @return array|mixed
     */
    public function getMiddleware(string $name): array
    {
        return $this->middlewareGroups[$name] ?? [];
    }
}