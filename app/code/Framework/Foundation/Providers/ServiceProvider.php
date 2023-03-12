<?php

namespace Sparkly\Framework\Foundation\Providers;

use Sparkly\Framework\Foundation\Application;

abstract class ServiceProvider
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    abstract public function boot(): void;
}
