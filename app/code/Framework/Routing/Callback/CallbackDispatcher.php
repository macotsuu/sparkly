<?php

namespace Sparkly\Framework\Routing\Callback;

use Psr\Http\Message\ResponseInterface as Response;
use ReflectionMethod;
use ReflectionParameter;
use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Routing\Route\Route;

class CallbackDispatcher
{
    private ContainerInterface $container;
    private CallbackResolver $callbackResolver;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->callbackResolver = new CallbackResolver();
    }

    /**
     * @param Route $route
     * @return Response
     */
    public function dispatch(Route $route): Response
    {
        $callback = $this->callbackResolver->resolve($route->callback());
        $reflector = new ReflectionMethod($callback->getClassname(), $callback->getMethod());
        $parameters = $route->getAttributes();


        foreach ($reflector->getParameters() as $key => $parameter) {
            $className = $this->getClassName($parameter);
            print_r($className);
            $instance = $className
                ? $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : $this->container->make(
                    $className
                )
                : null;


            array_splice(
                $parameters,
                $key,
                0,
                [$instance]
            );
        }

        return $this->call($callback->getClassname(), $callback->getMethod(), $parameters);
    }

    /**
     * @param $instance
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function call($instance, string $method, array $parameters = []): mixed
    {
        return call_user_func([new $instance(), $method], ...$parameters);
    }

    protected function getClassName(ReflectionParameter $parameter): null|string
    {
        $type = $parameter->getType();

        if ($type instanceof ReflectionNamedType || $type->isBuiltin()) {
            return null;
        }

        $name = $type->getName();

        if (!is_null($class = $parameter->getDeclaringClass())) {
            if ($name === 'self') {
                return $class->getName();
            }

            if ($name === 'parent' && $parent = $class->getParentClass()) {
                return $parent->getName();
            }
        }

        return $name;
    }
}
