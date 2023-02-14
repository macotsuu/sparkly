<?php

namespace Sparkly\System\Routing\Callable;

use Exception;

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
    public function getClassName(): string
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

    /**
     * @return object
     * @throws Exception
     */
    public function getClassInstance(): object
    {
        if (!class_exists($this->className)) {
            throw new Exception("{$this->className} not found!");
        }

        return new $this->className();
    }
}
