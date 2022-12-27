<?php

namespace BFST;

use BFST\Logger\LogLevel;

class Config
{
    public static function routes()
    {
        switch (true) {
            case str_contains(BFST_REQUEST_URI, 'login'):
            {
                if(!isset($_SESSION['user'])) {
                    require_once BFST_DIR_CORE . 'authorize.php';
                    break;
                }

                redirect("/");
            }

            case !isset($_SESSION['user']) && preg_match('/Authorize::(authorize)/', BFST_REQUEST_URI):
            case (bool)preg_match('/ajax\?func=/', BFST_REQUEST_URI):
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

    public static function topSettings(): void
    {
        preg_match('/BFST(alpha|beta)(\w+)?/', BFST_REQUEST_URI, $matches);

        ini_set("display_errors", "off");
        error_reporting(E_ALL);

        define('BFST_DIR_MODULES', BFST_DIR_CORE . 'modules/');
        define('BFST_DIR_CLASSES', BFST_DIR_CORE . 'classes/');

        define('BFST_URL', $matches[0]);
        define('BFST_STAGE', $matches[1]);
        define('BFST_ENVIRONMENT', $matches[1] ?: 'production');
        define('BFST_DEBUG', (isset($_GET['debug']) && $_GET['debug']) == 1 ? 1 : 0);

        define('BFST_LOG_LEVEL', LogLevel::DEBUG);
        define('BFST_APP_URL', "http://" . $_SERVER['HTTP_HOST'] . "/" . $matches[0]);
        define('BFST_ASSETS_URL', BFST_APP_URL . "/public/");
    }
}
