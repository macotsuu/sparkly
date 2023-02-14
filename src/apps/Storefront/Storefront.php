<?php

namespace Sparkly\Storefront;

use Sparkly\System\Application\Application;
use Sparkly\System\Routing\Router;

class Storefront extends Application
{
    public function __construct()
    {
        $this->name = 'storefront';
    }

    public function boot(): void
    {
        foreach (glob(__DIR__ . '/Resources/routes/*.php') as $routes) {
            (require $routes)($this->getContainer()->get(Router::class));
        }
    }
}