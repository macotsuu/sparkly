<?php

namespace Sparkly\Framework\Routing\Callback;

final class Callback
{
    public function __construct(
        private readonly string $className,
        private readonly string $method = '__invoke'
    ) {
    }

    /**
     * @return string
     */
    public function getClassname(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
