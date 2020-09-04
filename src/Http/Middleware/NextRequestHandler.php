<?php

namespace Oak\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class responsible for handling the next middleware in the stack.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
final class NextRequestHandler implements RequestHandlerInterface
{
    /**
     * @var MiddlewareStack $middlewareStack
     */
    private $middlewareStack;

    /**
     * @var CoreRequestHandler $coreRequestHandler
     */
    private $coreRequestHandler;

    /**
     * Next constructor.
     * @param MiddlewareStack $middlewareStack
     * @param CoreRequestHandler $coreRequestHandler
     */
    public function __construct(MiddlewareStack $middlewareStack, CoreRequestHandler $coreRequestHandler)
    {
        $this->middlewareStack = $middlewareStack;
        $this->coreRequestHandler = $coreRequestHandler;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->middlewareStack->hasNext()) {
            return $this->middlewareStack->process($request, $this);
        }

        // No more middleware to be processed, so we call our final core request handler
        return $this->coreRequestHandler->handle($request);
    }
}