<?php

namespace Sparkly\Framework\Foundation;

use Sparkly\Framework\Kernel\Kernel;

abstract class ServiceProvider
{
    protected Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    abstract public function boot(): void;
}
