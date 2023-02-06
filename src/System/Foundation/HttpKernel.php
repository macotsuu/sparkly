<?php

namespace Sparkly\System\Foundation;

use ReflectionException;
use Sparkly\System\Http\Request;
use Sparkly\System\Http\Response;
use Sparkly\System\Routing\RouteCollector\RouteCollectorProxy;
use Sparkly\System\Routing\Router;
use Sparkly\System\Container\Container;

class HttpKernel extends RouteCollectorProxy
{
    public const VERSION = '0.1.0-alpha';

    public function loadRoutes(string $pattern): void {
        foreach (glob($pattern) as $file) {
            (require_once $file)($this);
        }
    }

    public function handle(Request $request = null): Response
    {
        if ($request === null) {
            $request = new Request();
        }

        return (new Router($this->routeCollector))->dispatch($request);
    }

    /**
     * @param string $className
     * @return mixed
     * @throws ReflectionException
     */
    public function make(string $className): mixed
    {
        return Container::getInstance()->make($className);
    }
}
