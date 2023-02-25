<?php

namespace Sparkly\Core\Providers;

use Sparkly\Framework\Foundation\ServiceProvider;
use Sparkly\Framework\Log\Handler\FileHandler;
use Sparkly\Framework\Log\Handler\StdoutHandler;
use Sparkly\Framework\Log\Logger;
use Sparkly\Framework\Log\LogLevel;

class LogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->kernel['logger'] = (new Logger('app'))
            ->pushHandler(new StdoutHandler())
            ->pushHandler(new FileHandler(LogLevel::ERROR));
    }
}
