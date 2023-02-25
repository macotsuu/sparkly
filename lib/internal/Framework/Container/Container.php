<?php

namespace Sparkly\Framework\Container;

use ArrayAccess;
use Exception;
use LogicException;
use ReflectionException;

use function array_key_exists;

class Container implements ContainerInterface, ArrayAccess
{
    protected static Container $instance;
    protected array $aliases = [];
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
     */
    public function make(string $abstract, array $parameters = []): mixed
    {
        return $this->resolve($abstract, $parameters);
    }

    /**
     *
     * @param string $id
     * @return mixed
     */
    public function get(string $id): mixed
    {
        return $this->make($id);
    }

    /**
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->resolved[$id]);
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
        $abstractTmp = $abstract;

        $abstract = $this->getAlias($abstract);


        if (isset($this->resolved[$abstract])) {
            return $this->resolved[$abstract];
        }

        try {
            $reflection = new \ReflectionClass($abstract);
        } catch (ReflectionException $ex) {
            throw new Exception(sprintf('Unable to create object `%s`.', $abstract), 0, $ex);
        }
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
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
        }

        $resolved = $constructor === null
            ? $reflection->newInstance()
            : $reflection->newInstance(...$dependencies);

        $this->resolved[$abstract] = $resolved;

        return $resolved;
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
        return isset($this->resolved[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param string $offset
     * @return mixed
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
        if (is_null($offset)) {
            $this->resolved[] = $value;
        } else {
            $this->resolved[$this->getAlias($offset)] = $value;
        }
    }

    /**
     * Unset an offset
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->resolved[$offset]);
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
