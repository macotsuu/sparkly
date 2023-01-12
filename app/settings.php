<?php

use Volcano\Application;

if (!defined('BFST_DIR')) {
    define('BFST_DIR', dirname(__DIR__));
}

return function (Application $app) {
    if (preg_match('/BFST((\w)+)?/', $app->request->uri()->path, $matches)) {
        $app->stage = $matches[0];
    }

    foreach ([config()->path()->logs] as $dir) {
        if (file_exists($dir) === false) {
            mkdir($dir, 0777, true);
            chmod($dir, 0770);
        }
    }
};
