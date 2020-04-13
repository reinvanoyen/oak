<?php

namespace Oak\Session\Middleware;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionGarbageLottery implements MiddlewareInterface
{
    /**
     * @var RepositoryInterface $config
     */
    private $config;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * SessionGarbageLottery constructor.
     * @param RepositoryInterface $config
     * @param Session $session
     */
    public function __construct(RepositoryInterface $config, Session $session)
    {
        $this->config = $config;
        $this->session = $session;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Garbage collection lottery
        if (rand(0, $this->config->get('session.lottery', 200)) === 1) {
            $this->session->getHandler()->gc($this->config->get('session.max_lifetime', 1000));
        }

        return $handler->handle($request);
    }
}