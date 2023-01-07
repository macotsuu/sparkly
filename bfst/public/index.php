<?php

define('BFST_APP_START', microtime(true));
define('BFST_DIR', dirname(__DIR__) . '/');

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require_once BFST_DIR . 'app/init.php';

define('BFST_APP_END', microtime(true));
