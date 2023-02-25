<?php

namespace Sparkly\Framework\Routing\Callback;

use Psr\Http\Message\ResponseInterface as Response;
use Sparkly\Framework\Routing\Route\Route;

class CallbackDispatcher
{
    private CallbackResolver $callbackResolver;

    public function __construct()
    {
        $this->callbackResolver = new CallbackResolver();
    }

    /**
     * @param Route $route
     * @return Response
     */
    public function dispatch(Route $route): Response
    {
        return $this->call(
            $this->callbackResolver->resolve($route->callback())
        );
    }

    public function call(Callback $callback): mixed
    {
        return call_user_func([new ($callback->getClassname()), $callback->getMethod()]);
    }
}
