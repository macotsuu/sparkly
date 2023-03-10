<?php

namespace Sparkly\Framework\Log\Handler;

use Sparkly\Framework\Foundation\Path;
use Sparkly\Framework\Log\LogRecord;

class FileHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(LogRecord $record): bool
    {
        file_put_contents(
            sparkly()->path(Path::LOG_PATH) . $this->channel . '/' . $record->level->name() . ".log",
            $record->format(),
            FILE_APPEND
        );

        return true;
    }
}
