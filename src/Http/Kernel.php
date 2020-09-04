<?php

namespace Oak\Http;

use Oak\Contracts\Http\ResponseEmitterInterface;
use Oak\Contracts\Http\Routing\RouterInterface;
use Oak\Contracts\Http\KernelInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * The heart and soul of HTTP. This class is responsible for handling a request.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
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
        $this->responseEmitter->emit(
            $this->router->dispatch($request)
        );
    }
}