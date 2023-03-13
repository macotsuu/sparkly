<?php

namespace Sparkly\Framework\Foundation\Providers;

use Sparkly\Framework\Log\Handler\FileHandler;
use Sparkly\Framework\Log\Handler\StdoutHandler;
use Sparkly\Framework\Log\Logger;
use Sparkly\Framework\Log\LogLevel;

class LogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app['logger'] = (new Logger('app'))
            ->pushHandler(new StdoutHandler())
            ->pushHandler(new FileHandler(LogLevel::ERROR));
    }
    public function boot(): void
    {
    }
}
