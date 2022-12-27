<?php

try {
    preg_match('/(.*)::(\w+)$/', $_GET['func'], $method);

    $params = array();

    if (isset($_POST)) {
        foreach ($_POST as $key => $value) {
            if ($key === 'func') {
                continue;
            }

            $params[$key] = $value;
        }
    }

    if (isset($_GET)) {
        foreach ($_GET as $key => $value) {
            if ($key === 'func') {
                continue;
            }

            $params[$key] = $value;
        }
    }

    $instance = new $method[1]();
    $response = $instance->{$method[2]}(...$params);

    if (is_array($response) || is_object($response)) {
        $json = json_encode($response);

        if (json_last_error()) {
            throw new Exception(json_last_error_msg(), json_last_error());
        }
        $response = $json;
    }

    echo $response;
} catch (Exception $e) {
    register_shutdown_function(function () use ($e) {
        header('AjaxException: 1');

        if (BFST_STAGE === 'production') {
            exit("Wystąpił błąd...");
        }

        echo $e->getMessage() . PHP_EOL . $e->getTraceAsString();
    });
}