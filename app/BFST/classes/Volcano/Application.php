<?php

namespace Volcano;

use Exception;
use Volcano\Callback\CallbackResolver;
use Volcano\Http\Request;
use Volcano\Routing\Route;
use Volcano\Routing\Router;

class Application
{
    public Request $request;
    public string $stage = 'BFST';

    private static ?Application $instance = null;

    private readonly Router $router;
    private readonly CallbackResolver $callbackResolver;
    private array $container = [];

    private function __construct()
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->callbackResolver = new CallbackResolver();
    }

    /**
     * @param array $methods
     * @param string $path
     * @param mixed $handler
     * @return void
     */
    public function route(array $methods, string $path, mixed $handler): void
    {
        $this->router->match($methods, '/' . $this->stage . $path, $handler);
    }

    /**
     * @param Request|null $request
     * @return void
     * @throws Exception
     */
    public function run(Request $request = null): void
    {
        if ($request === null) {
            $request = $this->request;
        }

        $route = $this->handle($request->uri()->path, $request->method);
        $callback = $this->callbackResolver->resolve($route->handler);
        $callback->execute();
    }

    /**
     * @param string $class
     * @param array|null $params
     * @return mixed
     */
    public function make(string $class, array $params = null): mixed
    {
        if (!isset($this->container[$class])) {
            $this->container[$class] = new $class();
        }

        return $this->container[$class];
    }

    /**
     * @return Application
     */
    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    /**
     * @param string $path
     * @param string $method
     * @return Route
     * @throws Exception
     */
    private function handle(string $path, string $method): Route
    {
        $route = $this->router->dispatch($path, $method);

        if ($route === false) {
            throw new Exception("NOT FOUND");
        }

        return $route;
    }
}
