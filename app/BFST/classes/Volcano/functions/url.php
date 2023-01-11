<?php

if (!function_exists('assets')) {
    /**
     * @param string $url
     * @return string
     */
    function assets(string $url): string
    {
        return BFST_APP_URL . $url;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header("Location: " . BFST_APP_URL . $path, true, 302);
    }

}
