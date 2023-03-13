<?php

namespace Sparkly\Framework\Foundation\Providers;

use Closure;
use Sparkly\Framework\Routing\Router;

class RoutingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRouter();
    }

    private function registerRouter(): void
    {
        $this->app->bind(Router::class, function () {
            return new Router($this->app);
        });
    }

    protected function routes(Closure $closure): void
    {
        $this->callback($closure);
    }
}
