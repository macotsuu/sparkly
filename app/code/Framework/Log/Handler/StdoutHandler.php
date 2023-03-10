<?php

namespace Sparkly\Framework\Log\Handler;

use Sparkly\Framework\Log\LogRecord;

class StdoutHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(LogRecord $record): bool
    {
        echo $record->format();

        return true;
    }
}
