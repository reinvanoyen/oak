<?php

namespace Oak\Http\Middleware;

use Oak\Http\Controller\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class responsible for executing the core layer of middleware.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class CoreRequestHandler implements RequestHandlerInterface
{
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
     * @param $controller
     * @param string $method
     * @param array $params
     */
    public function __construct(BaseController $controller, string $method, array $params = [])
    {
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

        // Check if we already have a response
        if ($output instanceof ResponseInterface) {

            // It's already a response, return it
            return $output;
        }

        // Get the response from the controller
        $response = $this->controller->getResponse();

        // ...and write to its body
        $response->getBody()->write($output);

        return $response;
    }
}