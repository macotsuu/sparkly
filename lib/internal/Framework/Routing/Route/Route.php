<?php

namespace Sparkly\Framework\Routing\Route;

use Psr\Http\Message\ResponseInterface;
use Sparkly\Framework\Routing\Callback\CallbackDispatcher;

final class Route
{
    /** @var array $attributes */
    private array $attributes;

    /** @var array $methods */
    private array $methods;

    /** @var string */
    private string $uri;

    /** @var string|array */
    private string|array $callback;

    /** @var array $middlewares */
    private array $middlewares = [];

    public function __construct(array $methods, string $uri, array|string $callback)
    {
        $this->uri = $uri;
        $this->methods = $methods;
        $this->callback = $callback;

        $this->pattern($this->uri);
    }

    private function pattern(string $uri): void
    {
        $this->uri = "#^$uri$#sD";
    }

    public function run(): ResponseInterface
    {
        return (new CallbackDispatcher())->dispatch($this);
    }

    /**
     * @return array
     */
    public function methods(): array
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * @return array|string
     */
    public function callback(): array|string
    {
        return $this->callback;
    }

    /**
     * @return array
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     * @return $this
     */
    public function addMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute(string $key, mixed $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key): mixed
    {
        if (!isset($this->attributes[$key])) {
            return null;
        }
        return $this->attributes[$key];
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
