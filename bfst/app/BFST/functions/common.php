<?php
    if (!function_exists('env')) {
        /**
         * @param string $var
         * @param string|null $default
         * @return mixed
         */
        function env(string $var, string $default = null): mixed {
            return $_ENV[$var] ?? $default;
        }
    }