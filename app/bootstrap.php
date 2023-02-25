<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php') === false) {
    trigger_error(
        'Composer dependencies have not been set up yet run ',
        E_USER_ERROR
    );
}

require_once __DIR__ . '/../vendor/autoload.php';
