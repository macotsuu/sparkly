<?php

define('APP_START', microtime(true));
define('SPARKLY_ROOT_DIR', dirname(__DIR__) . '/');

if (file_exists(SPARKLY_ROOT_DIR . 'vendor/autoload.php') === false) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}

require_once SPARKLY_ROOT_DIR . 'vendor/autoload.php';

try {
    (new \Sparkly\System\Sparkly())->run();
} catch (\Throwable $ex) {
    echo "<pre>";
    echo $ex->getMessage() . PHP_EOL;
    echo $ex->getTraceAsString() . PHP_EOL;
    echo "</pre>";
}

define('APP_END', microtime(true));
