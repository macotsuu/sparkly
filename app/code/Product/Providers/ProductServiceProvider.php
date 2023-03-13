<?php

namespace Sparkly\Product\Providers;

use Sparkly\Framework\Foundation\Providers\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerProviders();
    }

    protected function registerProviders()
    {
        $this->app->register(new RoutingServiceProvider($this->app));
    }
}
