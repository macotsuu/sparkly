<?php

use Volcano\Application;
use Volcano\Configuration\Configuration;
use Volcano\Foundation\Cache;
use Volcano\Foundation\MySQL;
use Volcano\Logger\Logger;

if (!function_exists('logger')) {
    function logger(): Logger
    {
        return Application::getInstance()->make(Logger::class);
    }
}

if (!function_exists('config')) {
    function config(): Configuration
    {
        return Application::getInstance()->make(Configuration::class);
    }
}

if (!function_exists('cache')) {
    function cache(): Cache
    {
        return Application::getInstance()->make(Cache::class);
    }
}

if (!function_exists('mysql')) {
    function mysql(): MySQL
    {
        return Application::getInstance()->make(MySQL::class);
    }
}

if (!function_exists('env')) {
    /**
     * @param string $var
     * @param string|null $default
     * @return mixed
     */
    function env(string $var, string $default = null): mixed
    {
        return $_ENV[$var] ?? $default;
    }
}

if (!function_exists('assets')) {
    /**
     * @param string $url
     * @return string
     */
    function assets(string $url): string
    {
        return 'public/' . $url;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header("Location: " . $path, true, 302);
    }
}
