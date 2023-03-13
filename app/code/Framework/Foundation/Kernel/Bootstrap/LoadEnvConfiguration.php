<?php

namespace Sparkly\Framework\Foundation\Kernel\Bootstrap;

use Sparkly\Framework\Foundation\Path;
use Symfony\Component\Dotenv\Dotenv;
use Sparkly\Framework\Foundation\Application;
use Symfony\Component\Dotenv\Exception\PathException;

final class LoadEnvConfiguration
{
    public function boot(Application $app): void
    {
        try {
            $dotenv = new Dotenv();
            $dotenv->load($app->path(Path::BASE_PATH) . '.env');
        } catch (PathException) {
        }
    }
}
