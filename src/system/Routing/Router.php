<?php

namespace Sparkly\System\Routing;

use Exception;
use Sparkly\System\Routing\RouteCollector\RouteCollectorProxy;
use Sparkly\System\Http\Request;
use Sparkly\System\Http\Response;
use Sparkly\System\Routing\Route\Route;
use Sparkly\System\Routing\Route\RouteDispatcher;
use Sparkly\System\Routing\RouteCollector\RouteCollector;

final class Router extends RouteCollectorProxy
{
    private RouteDispatcher $routeDispatcher;

    public function __construct(RouteCollector $routeCollector = null)
    {
        parent::__construct($routeCollector);

        $this->routeDispatcher = new RouteDispatcher($this->routeCollector);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function dispatch(Request $request): Response
    {
        return $this->runRoute(
            $request,
            $this->matchRoute($request)
        );
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return Response
     */
    private function runRoute(Request $request, Route $route): Response
    {
        return $this->prepareResponse(
            $request,
            $this->runRouteStack($route, $request)
        );
    }

    /**
     * @param Request $request
     * @param Response|null $response
     * @return Response
     */
    private function prepareResponse(Request $request, ?Response $response): Response
    {
        return $response ?: new Response('');
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return ?Response
     */
    private function runRouteStack(Route $route, Request $request): ?Response
    {
        return (new Pipeline())
            ->send($request)
            ->through($route->middlewares())
            ->then(fn($request) => $this->prepareResponse($request, $route->run()));
    }

    /**
     * @param Request $request
     * @return Route
     * @throws Exception
     */
    private function matchRoute(Request $request): Route
    {
        $route = $this->routeDispatcher->dispatch($request->uri()->path, $request->getMethod());

        if ($route === null) {
            throw new Exception("Route not found");
        }

        return $route;
    }

}