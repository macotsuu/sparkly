<?php

namespace Volcano\Routing\RouteCollector;

use Volcano\Http\Middleware\MiddlewareInterface;
use Volcano\Routing\Route\Route;
use Volcano\Routing\Route\RouteGroup;

class RouteCollectorProxy
{
    /** @var RouteCollector $routeCollector */
    protected RouteCollector $routeCollector;
    /** @var string $groupPattern */
    private string $groupPattern = '';

    public function __construct(
        ?RouteCollector $routeCollector = null,
        ?string $groupPattern = null
    ) {
        $this->routeCollector = $routeCollector ?: new RouteCollector();
        $this->groupPattern = $groupPattern ?: '';
    }

    /**
     * @param string $uri
     * @param string|array $callback
     * @return Route
     */
    public function get(string $uri, string|array $callback): Route
    {
        return $this->map(['GET'], $uri, $callback);
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param string|array $callback
     * @return Route
     */
    public function map(array $methods, string $uri, string|array $callback): Route
    {
        return $this->routeCollector->map($methods, $this->groupPattern . $uri, $callback);
    }

    /**
     * @param string $uri
     * @param string|array $callback
     * @return Route
     */
    public function post(string $uri, string|array $callback): Route
    {
        return $this->map(['POST'], $uri, $callback);
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return RouteCollector
     */
    public function use(MiddlewareInterface $middleware): RouteCollector
    {
        return $this->routeCollector->use($middleware);
    }

    /**
     * @param array $attributes
     * @param $callable
     * @return RouteGroup
     */
    public function group(array $attributes, $callable): RouteGroup
    {
        if (!isset($attributes['prefix'])) {
            $attributes['prefix'] = '';
        }

        $attributes['prefix'] .= $this->groupPattern;

        return $this->routeCollector->group($attributes, $callable);
    }
}