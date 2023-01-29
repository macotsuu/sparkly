<?php

namespace Volcano\Http\Middleware;

use Closure;
use Volcano\Http\Request;
use Volcano\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response;
}