<?php

namespace Volcano\Foundation\Providers;

use Throwable;

class RoutingServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->routes(function ($routes) {
            array_walk($routes, function ($route) {
                (require_once $route)($this->app);
            });
        });
    }

    private function routes(callable $callback): void
    {
        try {
            $callback($this->getRoutes());
        } catch (Throwable $exception) {
        }
    }

    private function getRoutes(): array
    {
        return glob($this->app->basePath('app') . '/**/resources/routes.php');
    }
}