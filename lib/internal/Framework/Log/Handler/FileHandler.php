<?php

namespace Sparkly\Framework\Log\Handler;

use Sparkly\Framework\Log\LogRecord;

class FileHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(LogRecord $record): bool
    {
        file_put_contents(
            sparkly()->getLogDir() . $this->channel . '/' . $record->level->name() . ".log",
            $record->format(),
            FILE_APPEND
        );

        return true;
    }
}
