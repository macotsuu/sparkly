<?php

namespace Sparkly\Core\Providers;

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
