<?php

if (file_exists(BFST_DIR . 'vendor/autoload.php') === false) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}

require_once BFST_DIR . 'vendor/autoload.php';

session_start();

$app = new \Volcano\Application();

require_once BFST_DIR . 'app/settings.php';
(require_once BFST_DIR . 'app/routes.php')($app);

try {
    $app->run();
} catch (Exception $e) {
}
