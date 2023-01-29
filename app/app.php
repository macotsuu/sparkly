<?php

use BFST\Base\Application;
use Dotenv\Dotenv;

if (!defined('BFST_DIR')) {
    define('BFST_DIR', dirname(__DIR__));
}

session_start();

if (file_exists(BFST_DIR . '.env')) {
    $dotenv = Dotenv::createImmutable(BFST_DIR);
    $dotenv->load();
}

try {
    $app = new Application(BFST_DIR);
    $app->boot();
    $app->run();
} catch (Exception $exc) {
    echo "<pre>";
    print_r($exc->getMessage());
    print_r($exc->getTraceAsString());
    echo "</pre>";
}