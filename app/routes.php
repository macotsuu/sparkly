<?php

use Volcano\Application;
use Volcano\Handlers\AjaxHandler;
use Volcano\Handlers\AuthorizationHandler;
use Volcano\Handlers\MainPageHandler;

return function (Application $app) {
    $app->route(['GET'], '/', MainPageHandler::class);
    $app->route(['GET'], '/authorize', AuthorizationHandler::class);
    $app->route(['POST'], '/ajax', AjaxHandler::class);
};
