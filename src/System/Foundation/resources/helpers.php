<?php
    if (!function_exists('env')) {
        /**
         * @param string $key
         * @param mixed $default
         * @return mixed
         */
        function env(string $key, mixed $default = null): mixed {
            return isset($_ENV[$key]) ? $_ENV[$key] : $default;
        }
    }