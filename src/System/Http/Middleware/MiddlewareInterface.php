<?php

namespace Sparkly\System\Http\Middleware;

use Closure;
use Sparkly\System\Http\Request;
use Sparkly\System\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response;
}