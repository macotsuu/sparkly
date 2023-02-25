<?php

namespace Sparkly\Framework\Log;

use DateTimeImmutable;
use Exception;
use Sparkly\Framework\Log\Handler\HandlerInterface;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    /** @var string $channel */
    public string $channel;

    /** @var array<HandlerInterface> $handlers */
    public array $handlers = [];

    public function __construct(string $channel = null)
    {
        $this->channel = $channel ?: 'app';
    }

    /**
     * @param HandlerInterface $handler
     * @return $this
     */
    public function pushHandler(HandlerInterface $handler): self
    {
        array_unshift($this->handlers, $handler);

        return $this;
    }

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        $this->addRecord($level, $message, $context);
    }

    private function addRecord(LogLevel $level, string $message, array $context = []): bool
    {
        $handled = false;

        $record = new LogRecord(
            channel: $this->channel,
            datetime: new DateTimeImmutable(),
            level: $level,
            message: $message
        );

        foreach ($this->handlers as $handler) {
            try {
                if ($handler->isHandling($record)) {
                    $handled = true;

                    if (true === $handler->handle($record)) {
                        break;
                    }
                }
            } catch (Exception $exception) {
                return true;
            }
        }

        return $handled;
    }
}
