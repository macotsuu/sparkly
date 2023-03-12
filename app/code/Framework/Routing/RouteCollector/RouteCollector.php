<?php

namespace Sparkly\Framework\Routing\RouteCollector;

use Closure;
use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Routing\MiddlewareInterface;
use Sparkly\Framework\Routing\Route\Route;
use Sparkly\Framework\Routing\Route\RouteGroup;

class RouteCollector
{
    /** @var array<string, Route> $routes */
    private array $routes = [];

    /** @var array<MiddlewareInterface> $middlewares */
    private array $middlewares = [];
    /** @var ContainerInterface $container */
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function group(array $attributes, Closure $callable): RouteGroup
    {
        if (isset($attributes['middlewares'])) {
            foreach ($attributes['middlewares'] as $middleware) {
                $this->use($middleware);
            }
        }

        $routeCollectorProxy = new RouteCollectorProxy(
            $this->container,
            $this,
            $attributes['prefix']
        );

        $routeGroup = new RouteGroup($attributes, $callable, $routeCollectorProxy);
        $routeGroup->collectRoutes();

        return $routeGroup;
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function use(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param string|array $callback
     * @return Route
     */
    public function map(array $methods, string $uri, string|array $callback): Route
    {
        $route = $this->newRoute($methods, $uri, $callback);
        $route->addMiddlewares($this->middlewares);

        foreach ($route->methods() as $method) {
            $this->routes[$method][] = $route;
        }

        return $route;
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param string|array $callback
     * @return Route
     */
    private function newRoute(array $methods, string $uri, string|array $callback): Route
    {
        return (new Route($methods, $uri, $callback))
            ->setContainer($this->container);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }
}
