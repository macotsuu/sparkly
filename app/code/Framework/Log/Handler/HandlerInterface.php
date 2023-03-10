<?php

namespace Sparkly\Framework\Log\Handler;

use Sparkly\Framework\Log\LogRecord;

interface HandlerInterface
{
    /**
     * @param LogRecord $record
     * @return bool
     */
    public function handle(LogRecord $record): bool;
}
