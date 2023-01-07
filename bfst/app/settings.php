<?php

use Volcano\Logger\LogLevel;
use Dotenv\Dotenv;

if (file_exists(BFST_DIR . '.env')) {
    $dotenv = Dotenv::createImmutable(BFST_DIR);
    $dotenv->load();
}

// Common
define('BFST_ENVIRONMENT', env('BFST_ENVIRONMENT', 'production'));
define('BFST_DEBUG', (isset($_GET['debug']) && $_GET['debug']) == 1 ? 1 : 0);
const BFST_LOG_LEVEL = LogLevel::DEBUG;

// DIRS
const BFST_DIR_APP = BFST_DIR . 'app/';
const BFST_DIR_CORE = BFST_DIR_APP . 'BFST/';
const BFST_DIR_MODULES = BFST_DIR_CORE . 'modules/';
const BFST_DIR_CLASSES = BFST_DIR_CORE . 'classes/';
const BFST_DIR_VAR = BFST_DIR . 'var/';
const BFST_DIR_LOG = BFST_DIR_VAR . 'logs/';

if (BFST_ENVIRONMENT !== 'testing') {
    // URLs
    define('BFST_HTTP_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://");
    define('BFST_HTTP_HOST', filter_input(INPUT_SERVER, 'HTTP_HOST'));
    define('BFST_HTTP_URI', filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));

    preg_match('/BFST(alpha|beta)(\w+)?/', BFST_HTTP_URI, $matches);
    define('BFST_APP_URL', BFST_HTTP_PROTOCOL . BFST_HTTP_HOST . "/" . $matches[0]);
    define('BFST_ASSETS_URL', BFST_APP_URL . "/public/");
    define('BFST_STAGE', $matches[1]);
}

foreach ([BFST_DIR_VAR, BFST_DIR_LOG] as $dir) {
    if (file_exists($dir) === false) {
        mkdir($dir, 0777, true);
        chmod($dir, 0770);
    }
}
