<?php

namespace Sparkly\Framework\Routing\Route;

use Sparkly\Framework\Routing\RouteCollector\RouteCollector;

class RouteResolver
{
    /** @var RouteDispatcher $routeDispatcher */
    private RouteDispatcher $routeDispatcher;

    public function __construct(RouteCollector $routeCollector, RouteDispatcher $routeDispatcher = null)
    {
        $this->routeDispatcher = $routeDispatcher ?: new RouteDispatcher($routeCollector);
    }

    /**
     * @param string $uri
     * @param string $method
     * @return Route|null
     */
    public function resolve(string $uri, string $method): ?Route
    {
        $uri = rawurldecode($uri);
        if ($uri === '' || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        return $this->routeDispatcher->dispatch($uri, $method);
    }
}
