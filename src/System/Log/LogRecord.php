<?php

namespace Sparkly\System\Log;

use DateTimeImmutable;

class LogRecord
{
    public function __construct(
        public DateTimeImmutable $datetime,
        public LogLevel $level,
        public string $message
    ) {
    }

    public function format(): string
    {
        return sprintf(
            "%s [%s] %s\n",
            $this->datetime->format('Y-m-d H:i:s'),
            $this->level->name(),
            $this->message
        );
    }
}