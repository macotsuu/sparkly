<?php

use BFST\Order\Application\ListOrder\ListOrderController;
use BFST\Order\Application\SearchOrder\SearchOrderController;
use Volcano\Routing\RouteCollector\RouteCollectorProxy;

return function (RouteCollectorProxy $router) {
    $router->get('/orders', ListOrderController::class);
    $router->get('/api/orders/search', SearchOrderController::class);
};