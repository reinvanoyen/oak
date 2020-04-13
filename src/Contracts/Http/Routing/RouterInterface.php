<?php

namespace Oak\Contracts\Http\Routing;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function dispatch(ServerRequestInterface $request): ResponseInterface;
}