<?php

namespace Oak\Contracts\Http\Middleware;

interface MiddlewareRegisterInterface
{
    public function middleware(string $name, array $middleware);
    public function getMiddleware(string $name): array;
}