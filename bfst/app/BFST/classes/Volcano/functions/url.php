<?php

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
        header("Location: " . '/BFSTalpha/' . $path, true, 302);
    }

}
