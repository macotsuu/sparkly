<?php

namespace Volcano\Routing;

use Exception;
use Volcano\Http\Request;
use Volcano\Http\Response;
use Volcano\Routing\Route\Route;
use Volcano\Routing\Route\RouteDispatcher;
use Volcano\Routing\RouteCollector\RouteCollector;

class Router
{
    private RouteCollector $routeCollector;
    private RouteDispatcher $routeDispatcher;

    public function __construct(RouteCollector $routeCollector = null)
    {
        $this->routeCollector = $routeCollector ?: new RouteCollector();
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
     * @param Response $response
     * @return Response
     */
    private function prepareResponse(Request $request, Response $response): Response
    {
        return $response;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return Response
     */
    private function runRouteStack(Route $route, Request $request): Response
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