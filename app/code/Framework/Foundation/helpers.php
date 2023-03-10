<?php

use Sparkly\Core\Kernel\Container\Container;

if (!function_exists('sparkly')) {
    function sparkly($abstract = null, array $params = [])
    {
        if ($abstract === null) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $params);
    }

}
