<?php

namespace Sparkly\Framework\Routing;

use Exception;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Sparkly\Framework\Routing\Exception\RouteNotFound;
use Sparkly\Framework\Routing\Route\Route;
use Sparkly\Framework\Routing\Route\RouteDispatcher;
use Sparkly\Framework\Routing\RouteCollector\RouteCollector;
use Sparkly\Framework\Routing\RouteCollector\RouteCollectorProxy;

final class Router extends RouteCollectorProxy
{
    public function __construct(?RouteCollector $routeCollector = null, ?string $groupPattern = null)
    {
        parent::__construct($routeCollector, $groupPattern);
    }

    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function dispatch(Request $request): ResponseInterface
    {
        return $this->runRoute(
            $request,
            $this->matchRoute($request)
        );
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return ResponseInterface
     */
    private function runRoute(Request $request, Route $route): ResponseInterface
    {
        return $this->prepareResponse(
            $request,
            $this->runRouteStack($route, $request)
        );
    }

    /**
     * @param Request $request
     * @param ResponseInterface|null $response
     * @return ResponseInterface
     */
    private function prepareResponse(Request $request, ?ResponseInterface $response): ResponseInterface
    {
        return $response ?: new \React\Http\Message\Response(200);
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return ?ResponseInterface
     */
    private function runRouteStack(Route $route, Request $request): ?ResponseInterface
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
        $route = (new RouteDispatcher($this->routeCollector))->dispatch($request->getUri()->getPath(), $request->getMethod());

        if ($route === null) {
            throw new RouteNotFound("Route {$request->getUri()->getPath()} not found");
        }

        return $route;
    }
}
