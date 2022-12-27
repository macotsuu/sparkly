<?php
if (!function_exists('assets')) {
    /**
     * @param string $url
     * @return string
     */
    function assets(string $url): string
    {
        return BFST_ASSETS_URL . $url;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header("Location: /" . BFST_URL . "{$path}", true, 302);
    }
}