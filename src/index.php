<?php

use Sparkly\System\Application\ApplicationLoader;

define('APP_START', microtime(true));
define('SPARKLY_ROOT_DIR', dirname(__DIR__) . '/');

if (file_exists(SPARKLY_ROOT_DIR . 'vendor/autoload.php') === false) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}

require_once SPARKLY_ROOT_DIR . 'vendor/autoload.php';

$bootloader = new ApplicationLoader();
$bootloader->load();
$bootloader->run();

define('APP_END', microtime(true));
