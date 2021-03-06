<?php

namespace Oak\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TrailingSlashMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if (strlen($path) > 1) {
            if (substr($path, -1) !== '/' && ! pathinfo($path, PATHINFO_EXTENSION)) {

                return $handler->handle($request)
                    ->withStatus(301)
                    ->withHeader('Location', $path.'/');
            }
        }

        return $handler->handle($request);
    }
}