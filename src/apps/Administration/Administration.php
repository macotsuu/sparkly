<?php

namespace Sparkly\Administration;

use Sparkly\System\Application\Application;
use Sparkly\System\Routing\Router;

class Administration extends Application
{
    public function __construct()
    {
        $this->name = 'administration';
    }

    public function boot(): void
    {
        foreach (glob(__DIR__ . '/Resources/routes/*.php') as $routes) {
            (require $routes)($this->getContainer()->get(Router::class));
        }
    }
}
