<?php

namespace Sparkly\Framework\Foundation\Bootstrap;

use Sparkly\Framework\Container\ContainerInterface;

abstract class Bootstrap
{
    protected ContainerInterface $app;

    abstract public function boot();

    public function setApplication(ContainerInterface $app): self
    {
        $this->app = $app;
        return $this;
    }

    public function getApplication(): ContainerInterface
    {
        return $this->app;
    }
}
