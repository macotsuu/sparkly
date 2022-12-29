<?php

namespace BFST;

use BFST\Logger\LogLevel;

class Config
{
    public static function constants(): void
    {
        // DIRS
        define("BFST_DIR_APP", BFST_DIR . 'app/');
        define("BFST_DIR_CORE", BFST_DIR_APP . 'BFST/');
        define('BFST_DIR_MODULES', BFST_DIR_CORE . 'modules/');
        define('BFST_DIR_CLASSES', BFST_DIR_CORE . 'classes/');
        define("BFST_DIR_VAR", BFST_DIR . 'var/');
        define("BFST_DIR_LOG", BFST_DIR_VAR . 'logs/');

        // URLs
        define('BFST_HTTP_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://");
        define('BFST_HTTP_HOST', filter_input(INPUT_SERVER, 'HTTP_HOST'));
        define('BFST_HTTP_URI', filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));

        preg_match('/BFST(alpha|beta)(\w+)?/', BFST_HTTP_URI, $matches);
        define('BFST_APP_URL', BFST_HTTP_PROTOCOL . BFST_HTTP_HOST . "/" . $matches[0]);
        define('BFST_ASSETS_URL', BFST_APP_URL . "/public/");

        // Common
        define('BFST_STAGE', $matches[1]);
        define('BFST_ENVIRONMENT', $matches[1] ?: 'production');
        define('BFST_DEBUG', (isset($_GET['debug']) && $_GET['debug']) == 1 ? 1 : 0);
        define('BFST_LOG_LEVEL', LogLevel::DEBUG);
    }
    public static function routes(): void
    {
        session_start();

        switch (true) {
            case str_contains(BFST_HTTP_URI, 'login'):
            {
                if(!isset($_SESSION['user'])) {
                    require_once BFST_DIR_CORE . 'authorize.php';
                    break;
                }

                redirect("/");
            }

            case !isset($_SESSION['user']) && preg_match('/Authorize::(authorize)/', BFST_HTTP_URI):
            case (bool)preg_match('/ajax\?func=/', BFST_HTTP_URI):
            {
                require_once BFST_DIR_CORE . "ajax.php";
                break;
            }

            default:
            {
                if (!isset($_SESSION['user'])) {
                    redirect("/login");
                }

                require_once BFST_DIR_CORE . 'main.php';
            }
        }
    }

    public static function settings(): void
    {
        ini_set("display_errors", "off");
        error_reporting(E_ALL);
    }
}
