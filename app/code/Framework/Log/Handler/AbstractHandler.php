<?php

namespace Sparkly\Framework\Log\Handler;

use Sparkly\Framework\Log\LogLevel;
use Sparkly\Framework\Log\LogRecord;

abstract class AbstractHandler
{
    protected LogLevel $logLevel;

    public function __construct(LogLevel $logLevel = LogLevel::INFO)
    {
        $this->setLevel($logLevel);
    }

    /**
     * @param LogLevel $level
     * @return $this
     */
    public function setLevel(LogLevel $level): self
    {
        $this->logLevel = $level;
        return $this;
    }

    /**
     * @param LogRecord $record
     * @return bool
     */
    public function isHandling(LogRecord $record): bool
    {
        return $record->level->value >= $this->logLevel->value;
    }
}
