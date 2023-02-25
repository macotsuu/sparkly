<?php

namespace Sparkly\Framework\Routing;

use Closure;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response;
}
