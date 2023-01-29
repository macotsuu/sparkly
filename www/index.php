<?php

use Dotenv\Dotenv;

define('BFST_APP_START', microtime(true));
define('BFST_DIR', dirname(__DIR__) . '/');

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

require_once BFST_DIR . 'app/app.php';

define('BFST_APP_END', microtime(true));
