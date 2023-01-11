<?php

    return function (\Volcano\Application $app) {
        $app->get('/', \Volcano\Handlers\MainPageHandler::class);
        $app->get('/authorize', \Volcano\Handlers\AuthorizationHandler::class);
        $app->post('/ajax', \Volcano\Handlers\AjaxHandler::class);
    };
