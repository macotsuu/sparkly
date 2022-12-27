<?php

use BFST\Config;
use BFST\ErrorHandling;
use Dotenv\Dotenv;

define('BFST_DIR', dirname(__DIR__) . '/');
define('BFST_REQUEST_URI', filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));

const BFST_DIR_APP = BFST_DIR . 'app/';
const BFST_DIR_CORE = BFST_DIR_APP . 'BFST/';
const BFST_DIR_VAR = BFST_DIR . 'var/';
const BFST_DIR_LOG = BFST_DIR_VAR . 'logs/';
const BFST_DIR_WWW = BFST_DIR . 'www/';

foreach ([
             BFST_DIR_VAR,
             BFST_DIR_LOG
         ] as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
        chmod($dir, 0770);
    }
}

if (!file_exists(BFST_DIR . 'vendor/autoload.php')) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}
require_once BFST_DIR . 'vendor/autoload.php';

session_start();

$dotenv = Dotenv::createImmutable(BFST_DIR);
$dotenv->load();

Config::topSettings();
ErrorHandling::errorHandler();
Config::routes();