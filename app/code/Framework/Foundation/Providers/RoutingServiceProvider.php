<?php

namespace Sparkly\Framework\Foundation\Providers;

class RoutingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach (glob($this->kernel->getProjectDir() . '/app/code/Sparkly/**/routes.php') as $file) {
            $routes = require_once $file;
            $routes($this->kernel);
        }
    }
}
