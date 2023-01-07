<?php
    return function(\Volcano\Application $app) {
        $app->get('/BFSTalpha', \Volcano\Handlers\MainPageHandler::class);
        $app->get('/BFSTalpha/authorize', \Volcano\Handlers\AuthorizationHandler::class);
        $app->post('/BFSTalpha/ajax', \Volcano\Handlers\AjaxHandler::class);
    };