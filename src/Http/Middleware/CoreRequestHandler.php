<?php

namespace Oak\Http\Middleware;

use Nyholm\Psr7\Response;
use Oak\Http\Controller\BaseController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CoreRequestHandler implements RequestHandlerInterface
{
    /**
     * @var ResponseFactoryInterface $responseFactory
     */
    private $responseFactory;

    /**
     * @var BaseController $controller
     */
    private $controller;

    /**
     * @var string $method
     */
    private $method;

    /**
     * @var array $params
     */
    private $params;

    /**
     * CoreRequestHandler constructor.
     * @param ResponseFactoryInterface $responseFactory
     * @param $controller
     * @param string $method
     * @param array $params
     */
    public function __construct(ResponseFactoryInterface $responseFactory, BaseController $controller, string $method, array $params = [])
    {
        $this->responseFactory = $responseFactory;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $output = call_user_func_array([$this->controller, $this->method,], $this->params);

        if ($output instanceof ResponseInterface) {
            return $output;
        }

        $response = $this->responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/html')
        ;

        $response->getBody()->write($output);
        $response->getBody()->rewind();

        return $response;
    }
}