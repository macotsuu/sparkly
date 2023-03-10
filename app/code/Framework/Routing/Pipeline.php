<?php

namespace Sparkly\Framework\Routing;

use Closure;
use Psr\Http\Message\ResponseInterface;

class Pipeline
{
    /** @var array<MiddlewareInterface> $stack */
    private array $stack = [];

    /** @var mixed $passable */
    private mixed $passable;
    private string $method = 'handle';

    /**
     * @param mixed $passable
     * @return $this
     */
    public function send(mixed $passable): self
    {
        $this->passable = $passable;
        return $this;
    }

    /**
     * @param mixed $middlewares
     * @return $this
     */
    public function through(mixed $middlewares): self
    {
        $this->stack = $middlewares;

        return $this;
    }

    /**
     * @param Closure $callable
     * @return ResponseInterface|null
     */
    public function then(Closure $callable): ?ResponseInterface
    {
        $pipeline = array_reduce(
            array_reverse($this->stack),
            $this->carry(),
            $this->prepareCallable($callable)
        );

        return $pipeline($this->passable);
    }

    protected function carry(): Closure
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                if (is_callable($pipe)) {
                    return $pipe($passable, $stack);
                }

                $parameters = [$passable, $stack];

                return method_exists($pipe, $this->method) ? $pipe->{$this->method}(...$parameters) : $pipe(...$parameters);
            };
        };
    }

    /**
     * @param Closure $destination
     * @return Closure
     */
    protected function prepareCallable(Closure $destination): Closure
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }
}
