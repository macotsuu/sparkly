<?php

namespace Sparkly\Product\Providers;

use Sparkly\Framework\Foundation\Application;
use Sparkly\Framework\Routing\Router;

class RoutingServiceProvider extends \Sparkly\Framework\Foundation\Providers\RoutingServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (Application $app) {
            $routes = require __DIR__ . '/../Resources/routes/web.php';
            $routes($app->make(Router::class));
        });
    }
}
