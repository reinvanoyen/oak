<?php

namespace Oak\Http\Routing;

trait HasRoutesTrait
{
    /**
     * @var array $routes
     */
    private $routes = [];

    /**
     * @param string $httpMethod
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    private function registerRoute(string $httpMethod, string $pattern, string $controller, string $method): Route
    {
        if (! isset($this->routes[$httpMethod])) {
            $this->routes[$httpMethod] = [];
        }

        $route = new Route($this, $pattern, $controller, $method);
        $this->routes[$httpMethod][] = $route;
        return $route;
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function get(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('GET', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function head(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('HEAD', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function post(string $pattern, string $controller, string $method): Route
    {
        $this->registerRoute('POST', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function put(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('PUT', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function delete(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('DELETE', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function patch(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('PATCH', $pattern, $controller, $method);
    }

    /**
     * @param string $pattern
     * @param $controller
     */
    public function options(string $pattern, string $controller, string $method): Route
    {
        return $this->registerRoute('OPTIONS', $pattern, $controller, $method);
    }

    /**
     * @param string $httpMethod
     * @return array
     */
    public function getRoutesByMethod(string $httpMethod): array
    {
        return $this->routes[$httpMethod] ?? [];
    }
}