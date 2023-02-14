<?php

namespace Sparkly\System\Http\Middleware;

use Closure;
use system\Http\Request;
use system\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response;
}