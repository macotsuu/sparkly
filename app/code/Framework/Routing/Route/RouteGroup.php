<?php

namespace Sparkly\Framework\Routing\Route;

use Closure;
use Sparkly\Framework\Routing\RouteCollector\RouteCollectorProxy;

/**
 * @method callable(RouteCollectorProxy $routeCollectorProxy)
 */
final class RouteGroup
{
    /** @var string $prefix */
    private string $prefix;

    public function __construct(
        private readonly array $attributes,
        private readonly Closure $callable,
        private readonly RouteCollectorProxy $routeCollectorProxy
    ) {
        $this->setPrefix($this->attributes);
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setPrefix(array $attributes): self
    {
        if (isset($attributes['prefix'])) {
            $this->prefix = $attributes['prefix'];
        }

        return $this;
    }

    /**
     * @return void
     */
    public function collectRoutes(): void
    {
        call_user_func_array($this->callable, [$this->routeCollectorProxy]);
    }
}
