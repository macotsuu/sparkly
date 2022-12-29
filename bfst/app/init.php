<?php

use BFST\Config;
use BFST\ErrorHandling;
use Dotenv\Dotenv;

define('BFST_DIR', dirname(__DIR__) . '/');

if (!file_exists(BFST_DIR . 'vendor/autoload.php')) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}
require_once BFST_DIR . 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(BFST_DIR);
$dotenv->load();

Config::constants();
ErrorHandling::errorHandler();
ErrorHandling::exceptionHandler();

Config::settings();

foreach ([BFST_DIR_VAR, BFST_DIR_LOG] as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
        chmod($dir, 0770);
    }
}
