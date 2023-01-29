<?php

use BFST\Base\Application;
use Volcano\Container\Container;

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

if (!function_exists('app')) {
    /**
     * @param string|null $abstract
     * @return null|Application
     */
    function app(string|null $abstract = null): ?Application
    {
        try {
            if (is_null($abstract)) {
                return Container::getInstance()->make(Application::class);
            }

            return Container::getInstance()->make($abstract);
        } catch (ReflectionException $ex) {
            return null;
        }
    }
}


if (!function_exists('assets')) {
    /**
     * @param string $url
     * @return string
     */
    function assets(string $url): string
    {
        return app()->publicPath($url);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header("Location: " . $path, true, 302);
    }
}
