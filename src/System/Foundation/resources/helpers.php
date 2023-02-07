<?php

if (!function_exists('env')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('assets')) {
    /**
     * @param string $path
     * @return string
     */
    function assets(string $path): string
    {
        return env('APP_URL') . $path;
    }
}