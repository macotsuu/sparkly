<?php

namespace Sparkly\Framework\Foundation\Providers;

use Sparkly\Framework\Foundation\Kernel;

abstract class ServiceProvider
{
    protected Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    abstract public function boot(): void;
}
