<?php

namespace Volcano\Routing\Route;

use Volcano\Routing\RouteCollector\RouteCollector;

class RouteResolver
{
    /** @var RouteCollector $routeCollector */
    private RouteCollector $routeCollector;
    /** @var RouteDispatcher $routeDispatcher */
    private RouteDispatcher $routeDispatcher;

    public function __construct(RouteCollector $routeCollector, RouteDispatcher $routeDispatcher = null)
    {
        $this->routeCollector = $routeCollector;
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