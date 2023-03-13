<?php

use Sparkly\Framework\Routing\Router;
use Sparkly\Product\Action\SearchProduct\SearchProductController;

return function (Router $router) {
        $router->get('/products', SearchProductController::class);
    };