<?php

namespace Oak\Session\Middleware;

use Oak\Contracts\Config\RepositoryInterface;
use Oak\Contracts\Cookie\CookieInterface;
use Oak\Contracts\Session\SessionIdentifierInterface;
use Oak\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSession implements MiddlewareInterface
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
     * @var CookieInterface $cookie
     */
    private $cookie;

    /**
     * @var SessionIdentifierInterface $sessionIdentifier
     */
    private $sessionIdentifier;

    /**
     * StartSession constructor.
     * @param RepositoryInterface $config
     * @param Session $session
     * @param CookieInterface $cookie
     * @param SessionIdentifierInterface $sessionIdentifier
     */
    public function __construct(RepositoryInterface $config, Session $session, CookieInterface $cookie, SessionIdentifierInterface $sessionIdentifier)
    {
        $this->config = $config;
        $this->session = $session;
        $this->cookie = $cookie;
        $this->sessionIdentifier = $sessionIdentifier;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Set session cookie
        $cookieName = $this->config->get('session.cookie_prefix', 'session').'_'.$this->session->getName();

        if (! $this->cookie->has($cookieName)) {

            // No session id found, so we generate one
            $sessionId = $this->sessionIdentifier->generate($this->config->get('session.identifier_length', 40));

            // Set the id in the cookie
            $this->cookie->set($cookieName, $sessionId);
        }

        $this->session->setId($this->cookie->get($cookieName));

        // Handle the response first
        $response = $handler->handle($request);

        // ...then save any possible session changes and additions
        $this->session->save();

        return $response;
    }
}