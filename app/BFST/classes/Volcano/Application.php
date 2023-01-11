<?php

namespace Volcano;

use Exception;
use Volcano\Callback\CallbackResolver;
use Volcano\Routing\Route;

class Application extends Routing\Router
{
    private readonly CallbackResolver $callbackResolver;

    public function __construct()
    {
        parent::__construct();

        $this->callbackResolver = new CallbackResolver();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $route = $this->handle(
            BFST_REQUEST_URI,
            filter_input(INPUT_SERVER, 'REQUEST_METHOD') ?: 'GET'
        );

        $callback = $this->callbackResolver->resolve($route->handler);
        $callback->execute();
    }

    /**
     * @param string $uri
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public function handle(string $uri, string $method): Route
    {
        $route = $this->dispatch($uri, $method);

        if (false === $route) {
            throw new Exception('Route not found.');
        }

        return $route;
    }
}
