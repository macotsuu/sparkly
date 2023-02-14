<?php

namespace Sparkly\System\Log;

use DateTimeImmutable;
use system\Log\LoggerInterface;
use system\Log\LoggerTrait;
use system\Log\LogLevel;
use system\Log\LogRecord;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        private readonly string $channel
    ) {
    }

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        if ($this->isHandling($level) === false) {
            return;
        }

        $record = new LogRecord(
            datetime: new DateTimeImmutable(),
            level: $level,
            message: $message
        );

        file_put_contents($level->name() . ".log", $record->format(), FILE_APPEND);
    }

    /**
     * @param LogLevel $level
     * @return bool
     */
    private function isHandling(LogLevel $level): bool
    {
        return $level->value >= 100;
    }
}
