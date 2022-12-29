<?php

try {
    preg_match('/(.*)::(\w+)$/', $_GET['func'], $method);

    $params = array();
    $directParams = true;

    if (isset($_REQUEST)) {
        foreach ($_REQUEST as $key => $value) {
            if ($key === 'func') {
                continue;
            } elseif ($key === 'directParams' && (int)$value == 0) {
                $directParams = false;
                continue;
            }

            $params[$key] = $value;
        }
    }

    $instance = new $method[1];
    $response = $directParams === true ? $instance->{$method[2]}(...$params) : $instance->{$method[2]}($params);

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

        if (BFST_ENVIRONMENT === 'production') {
            exit("Wystąpił błąd...");
        }

        echo $e->getMessage() . PHP_EOL . $e->getTraceAsString();
    });
}