<?php

namespace Sparkly\System\Routing\Callable;

use ReflectionException;
use ReflectionMethod;
use Sparkly\System\ORM\EntityManager;
use Sparkly\System\Routing\Route\Route;

class CallableDispatcher
{
    private CallbackResolver $callbackResolver;

    public function __construct()
    {
        $this->callbackResolver = new CallbackResolver();
    }

    /**
     * @param Route $route
     * @return mixed
     */
    public function dispatch(Route $route): mixed
    {
        $callback = $this->callbackResolver->resolve($route->callback());

        return $callback
            ->getClassInstance()
            ->{$callback->getMethod()}(
                ...$this->resolveDependencies($callback->getClassName())
            );
    }

    /**
     * @param string $className
     * @return array
     */
    private function resolveDependencies(string $className): array
    {
        $dependencies = [];

        try {
            $invoke = new ReflectionMethod($className, '__invoke');
            $parameters = $invoke->getParameters();

            foreach ($parameters as $parameter) {
                $dependenceClass = (string)$parameter->getType();
                $dependencies[] = new $dependenceClass(new EntityManager());
            }

            return $dependencies;
        } catch (ReflectionException $ex) {
            print_r($ex->getMessage() . PHP_EOL);
        }
        return $dependencies;
    }
}