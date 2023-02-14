<?php

namespace Sparkly\System\Container;

use Exception;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $services = [];


    /**
     * @throws ReflectionException
     */
    public function make($abstract): mixed
    {
        return $this->resolve($abstract);
    }

    /**
     * @param string|callable $concrete
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function resolve(string|callable $concrete): mixed
    {
        if (is_callable($concrete)) {
            return $concrete();
        }

        if (isset($this->services[$concrete])) {
            return $this->services[$concrete];
        }

        try {
            $reflection = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new Exception("Target class [$concrete] does not exist.");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $reflection->newInstance();
        }
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }

        try {
            $instance = $reflection->newInstanceArgs($params);
        } catch (ReflectionException $exception) {
        }

        $this->services[$concrete] = $instance;

        return $this->services[$concrete];
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function get(string $id): mixed
    {
        try {
            if (!isset($this->services[$id])) {
                $this->services[$id] = $this->resolve($id);
            }

            return $this->services[$id];
        } catch (ReflectionException | Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function has($id): bool
    {
        return isset($this->services[$id]);
    }
}
