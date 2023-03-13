<?php

namespace Sparkly\Framework\Foundation\Kernel\Http;

use Error;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\Response;
use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Routing\Exception\RouteNotFound;
use Sparkly\Product\Action\SearchProduct\SearchProductController;

final class HttpKernel implements HttpKernelInterface
{
    public function __construct(protected ContainerInterface $app)
    {
    }
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->handle($request);
        } catch (RouteNotFound) {
            return Response::html("Route {$request->getUri()->getPath()} - not found");
        } catch (Exception | Error $e) {
            echo $e->getMessage() . PHP_EOL;
            $this->app['logger']->info(
                sprintf(
                    "%s@(%s)\n%s\n",
                    $e->getFile(),
                    $e->getLine(),
                    $e->getMessage(),
                )
            );

            return Response::html("Internal Server Error");
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->app['router']->dispatch($request);
    }
}
