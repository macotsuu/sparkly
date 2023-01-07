<?php

define('BFST_APP_START', microtime(true));

if (PHP_SAPI == 'cli-server') {
    [$path]  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $path;
    if (is_file($file)) {
        return false;
    }
}

require_once '../app/init.php';

define('BFST_APP_END', microtime(true));
