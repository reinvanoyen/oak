<?php

namespace Rein\Http\Middleware;

use Closure;
use Rein\Http\Middleware\Contracts\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrailingSlashMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, Closure $next)
    {
        $uri = $request->getUri();

        //Add/remove slash
        if (strlen($uri) > 1) {
            if (substr($uri, -1) !== '/' && !pathinfo($uri, PATHINFO_EXTENSION)) {

                $uri .= '/';

                return new Response( $response->getContent(),301, [
                    'location' => $uri,
                ]);
            }
        }

        return $next($request, $response);
    }
}