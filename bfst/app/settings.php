<?php

use Volcano\Logger\LogLevel;

// Common
define('BFST_ENVIRONMENT', env('BFST_ENVIRONMENT', 'production'));
define('BFST_DEBUG', (isset($_GET['debug']) && $_GET['debug']) == 1 ? 1 : 0);
const BFST_LOG_LEVEL = LogLevel::DEBUG;

if (!defined('BFST_DIR')) {
    define('BFST_DIR', dirname(__DIR__));
}

// DIRS
const BFST_DIR_APP = BFST_DIR . 'app/';
const BFST_DIR_CORE = BFST_DIR_APP . 'BFST/';
const BFST_DIR_MODULES = BFST_DIR_CORE . 'modules/';
const BFST_DIR_CLASSES = BFST_DIR_CORE . 'classes/';
const BFST_DIR_VAR = BFST_DIR . 'var/';
const BFST_DIR_LOG = BFST_DIR_VAR . 'logs/';

foreach ([BFST_DIR_VAR, BFST_DIR_LOG] as $dir) {
    if (file_exists($dir) === false) {
        mkdir($dir, 0777, true);
        chmod($dir, 0770);
    }
}
