<?php

use Dotenv\Dotenv;

if (!defined('BFST_DIR')) {
    define('BFST_DIR', dirname(__DIR__) . '/');
}

if (file_exists(BFST_DIR . 'vendor/autoload.php') === false) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}

require_once BFST_DIR . 'vendor/autoload.php';

if (file_exists(BFST_DIR . '.env')) {
    $dotenv = Dotenv::createImmutable(BFST_DIR);
    $dotenv->load();
}

session_start();

$app = new \Volcano\Application();

require_once BFST_DIR . 'app/settings.php';
(require_once BFST_DIR . 'app/routes.php')($app);
\Volcano\Logger\Logger::logger()->debug('dominik/$result', print_r('test', true));

try {
    $app->run();
} catch (Exception $e) {}
