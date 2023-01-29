<?php

namespace Volcano\Foundation\Providers;

use Volcano\Foundation\Application;

abstract class ServiceProvider
{
    public function __construct(
        protected Application $app
    ) {
    }

    /**
     * @return void
     */
    abstract public function boot(): void;
}