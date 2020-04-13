<?php

namespace Rein\Http\Middleware\Contracts;

interface MiddlewareRegisterInterface
{
    public function middleware(string $name, array $middleware);
    public function getMiddleware(string $name): array;
}