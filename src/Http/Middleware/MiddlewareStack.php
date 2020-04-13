<?php

namespace Oak\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareStack
{
    /**
     * @var array $middleware
     */
    private $middleware;

    /**
     * @var int $currentIndex
     */
    private $currentIndex = -1;

    /**
     * MiddlewareStack constructor.
     * @param array $middleware
     */
    public function __construct(array $middleware = [])
    {
        $this->middleware = $middleware;
    }

    /**
     * Check whether a next middleware is available
     *
     * @return bool
     */
    public function hasNext(): bool
    {
        return isset($this->middleware[$this->currentIndex+1]);
    }

    /**
     * Process the next middleware
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $requestHandler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $requestHandler): ResponseInterface
    {
        $this->currentIndex = $this->currentIndex + 1;

        return $this->middleware[$this->currentIndex]->process($request, $requestHandler);
    }
}