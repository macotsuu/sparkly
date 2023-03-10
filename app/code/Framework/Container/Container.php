<?php

namespace Sparkly\Framework\Container;

use ArrayAccess;
use Closure;
use Exception;
use LogicException;
use ReflectionClass;
use ReflectionException;
use TypeError;

use function array_key_exists;

class Container implements ContainerInterface, ArrayAccess
{
    protected static Container $instance;
    protected array $aliases = [];
    protected array $abstractAliases = [];
    protected array $bindings = [];
    protected array $resolved = [];

    /**
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     * @throws LogicException
     */
    public function alias(string $abstract, string $alias): void
    {
        if ($abstract === $alias) {
            throw new LogicException("");
        }

        $this->aliases[$alias] = $abstract;
        $this->abstractAliases[$abstract][] = $alias;
    }

    /**
     *
     * @param string $name
     * @return bool
     */
    public function isAlias(string $name): bool
    {
        return isset($this->aliases[$name]);
    }

    /**
     *
     * @param string $abstract
     * @return string
     */
    public function getAlias(string $abstract): string
    {
        return $this->aliases[$abstract] ?? $abstract;
    }

    /**
     *
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function make(string $abstract, array $parameters = []): mixed
    {
        return $this->resolve($abstract, $parameters);
    }

    /**
     *
     * @param string $id
     * @return mixed
     * @throws ReflectionException
     */
    public function get(string $id): mixed
    {
        return $this->make($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->resolved[$id]) ||
            isset($this->bindings[$id]) ||
            $this->isAlias($id);
    }

    /**
     * @param string|callable $abstract
     * @return mixed
     */
    protected function getConcrete(string|callable $abstract): mixed
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]['concrete'];
        }

        return $abstract;
    }

    /**
     *
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    protected function resolve(string $abstract, array $parameters = []): mixed
    {
        $abstract = $this->getAlias($abstract);
        $concrete = $this->getConcrete($abstract);

        if (isset($this->resolved[$abstract])) {
            return $this->resolved[$abstract];
        }

        $resolved = ($concrete === $abstract || $concrete instanceof Closure)
            ? $this->build($concrete, $parameters)
            : $this->make($concrete, $parameters);

        $this->resolved[$abstract] = $resolved;

        return $resolved;
    }

    /**
     * @param string|Closure $concrete
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function build(string|Closure $concrete, array $parameters = []): mixed
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        try {
            $reflection = new ReflectionClass($concrete);
        } catch (ReflectionException $ex) {
            throw new Exception(sprintf('Unable to create object `%s`.', $concrete), 0, $ex);
        }

        if (!$reflection->isInstantiable()) {
            throw new Exception("Target [$concrete] is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if ($constructor === null) {
            return new $concrete();
        }
        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            if ($parameter->getType() && !$parameter->getType()->isBuiltin()) {
                $dependencies[] = $this->get($parameter->getType()->getName());
            } else {
                $name = $parameter->getName();

                if (!array_key_exists($name, $parameters)) {
                    if (!$parameter->isOptional()) {
                        throw new Exception("Can not resolve parameters");
                    }

                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    $dependencies[] = $parameters[$name];
                }
            }
        }

        return $reflection->newInstance(...$dependencies);
    }

    /**
     * @param string $abstract
     * @param Closure|string|null $concrete
     * @return void
     */
    public function bind(string $abstract, Closure|string|null $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }

        if (!$concrete instanceof Closure) {
            if (!is_string($concrete)) {
                throw new TypeError("Argument #2 ($concrete) must be of type Closure|string|null");
            }

            $concrete = function (ContainerInterface $container, array $parameters = []) use ($abstract, $concrete) {
                if ($abstract === $concrete) {
                    return $container->build($concrete);
                }

                return $container->resolve($concrete, $parameters);
            };
        }

        $this->bindings[$abstract] = compact('concrete');
    }

    /**
     *
     * @return static
     */
    public static function getInstance(): static
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Whether an offset exists
     *
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve
     *
     * @param string $offset
     * @return mixed
     * @throws ReflectionException
     */
    public function offsetGet($offset): mixed
    {
        return $this->make($offset);
    }

    /**
     * Assign a value to the specified offset
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, mixed $value): void
    {
        $this->bind($offset, $value instanceof Closure ? $value : fn() => $value);
    }

    /**
     * Unset an offset
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->resolved[$offset], $this->bindings[$offset]);
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this[$key];
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set(string $key, mixed $value): void
    {
        $this[$key] = $value;
    }
}
