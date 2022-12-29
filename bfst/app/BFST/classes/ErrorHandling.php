<?php

namespace BFST;

use BFST\Logger\Logger;
use Error;

class ErrorHandling
{
    public static function errorHandler(): void
    {
        set_error_handler(function (int $errno, string $str, string $file, int $line) {

            $hash = substr(md5(time()), 0, 10);
            $message = sprintf(
                "MESSAGE: %s\n FILE: %s at %d \n",
                $str,
                $file,
                $line
            );

            Logger::logger()->critical(
                "errors/critical_error_{$hash}",
                $message
            );

            exit(BFST_ENVIRONMENT === 'production' ? "Wystąpił błąd o numerze: $hash" : $message);
        });
    }

    public static function exceptionHandler(): void
    {
        set_exception_handler(function (Error $exception) {
            $hash = substr(md5(time()), 0, 10);
            $message = sprintf(
                "MESSAGE: %s\n TRACE: %s\n REQUEST: %s\n",
                $exception->getMessage(),
                $exception->getTraceAsString(),
                print_r($_REQUEST, true)
            );

            Logger::logger()->critical(
                "errors/unhandled_exceptions_{$hash}",
                $message
            );

            exit(BFST_ENVIRONMENT === 'production' ? "Wystąpił błąd o numerze: $hash" : $message);
        });
    }
}