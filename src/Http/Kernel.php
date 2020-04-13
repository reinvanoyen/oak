<?php

namespace Oak\Http;

use Oak\Contracts\Http\ResponseEmitterInterface;
use Oak\Contracts\Http\Routing\RouterInterface;
use Oak\Contracts\Http\KernelInterface;
use Psr\Http\Message\ServerRequestInterface;

class Kernel implements KernelInterface
{
    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var ResponseEmitterInterface $responseEmitter
     */
    private $responseEmitter;

    /**
     * Kernel constructor.
     * @param RouterInterface $router
     * @param ResponseEmitterInterface $responseEmitter
     */
    public function __construct(RouterInterface $router, ResponseEmitterInterface $responseEmitter)
    {
        $this->router = $router;
        $this->responseEmitter = $responseEmitter;
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function handle(ServerRequestInterface $request)
    {
        $response = $this->router->dispatch($request);

        $this->responseEmitter->emit($response);
    }
}