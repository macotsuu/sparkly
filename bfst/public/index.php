<?php

use BFST\Config;
use BFST\Logger\Logger;

define('BFST_APP_START', microtime(true));
require_once '../app/init.php';
Config::routes();
define('BFST_APP_END', microtime(true));

Logger::logger()->debug(
    'timers/execution_time',
    BFST_HTTP_URI . ' ' . round(BFST_APP_END - BFST_APP_START, 2) . ' s'
);