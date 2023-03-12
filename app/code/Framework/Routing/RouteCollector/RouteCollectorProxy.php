<?php

namespace Sparkly\Framework\Routing\RouteCollector;

use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Routing\MiddlewareInterface;
use Sparkly\Framework\Routing\Route\Route;
use Sparkly\Framework\Routing\Route\RouteGroup;

class RouteCollectorProxy
{
    /** @var RouteCollector $routeCollector */
    protected RouteCollector $routeCollector;

    /** @var string $groupPattern */
    private string $groupPattern = '';
    /** @var ContainerInterface $container */
    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container,
        ?RouteCollector $routeCollector = null,
        ?string $groupPattern = null
    ) {
        $this->routeCollector = $routeCollector ?: new RouteCollector($container);
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

        $attributes['prefix'] = $this->groupPattern . $attributes['prefix'];

        return $this->routeCollector->group($attributes, $callable);
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
