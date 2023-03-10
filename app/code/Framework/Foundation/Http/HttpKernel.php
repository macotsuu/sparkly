<?php

namespace Sparkly\Framework\Foundation\Http;

use Error;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\Response;
use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Routing\Exception\RouteNotFound;

final class HttpKernel
{
    public function __construct(protected Container $kernel)
    {
    }
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->kernel['router']->dispatch($request);
        } catch (RouteNotFound) {
            return Response::html("Route {$request->getUri()->getPath()} - not found");
        } catch (Exception | Error $e) {
            echo $e->getMessage() . PHP_EOL;
            $this->kernel['logger']->info(
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
}
