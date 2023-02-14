<?php

namespace Sparkly\System\Routing\Route;

use Sparkly\System\Routing\RouteCollector\RouteCollector;

class RouteDispatcher
{
    /** @var array $matches */
    private array $matches = [];
    /** @var RouteCollector $routeCollector */
    private RouteCollector $routeCollector;

    public function __construct(RouteCollector $routeCollector)
    {
        $this->routeCollector = $routeCollector;
    }

    /**
     * @param string $uri
     * @param string $method
     * @return Route|null
     */
    public function dispatch(string $uri, string $method): ?Route
    {
        $result = null;

        foreach ($this->routeCollector->getRoutes() as $routes) {
            foreach ($routes as $route) {
                if (!in_array($method, $route->methods())) {
                    break;
                }

                if ($this->matchRoute($route, $uri)) {
                    $params = $this->getRouteParams();

                    foreach ($params as $key => $value) {
                        $route->setAttribute($key, $value);
                    }

                    $result = $route;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * @param Route $route
     * @param string $uri
     * @return bool
     */
    private function matchRoute(Route $route, string $uri): bool
    {
        return preg_match($route->uri(), $uri, $this->matches);
    }

    /**
     * @return array
     */
    private function getRouteParams(): array
    {
        return array_filter($this->matches, static function ($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);
    }
}
