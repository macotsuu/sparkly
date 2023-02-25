<?php

namespace Sparkly\Core\HttpKernel;

use Error;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\Response;
use Sparkly\Framework\Kernel\Kernel;
use Sparkly\Framework\Routing\Exception\RouteNotFound;

final class HttpKernel implements HttpKernelInterface
{
    public function __construct(protected Kernel $kernel)
    {
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        try {
            if ($this->kernel->isBooted() === false) {
                $this->kernel->boot();
            }

            return $this->handle($request);
        } catch (RouteNotFound) {
            return Response::html("Route {$request->getUri()->getPath()} - not found");
        } catch (Exception | Error $e) {
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

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->kernel['router']->dispatch($request);
    }
}
