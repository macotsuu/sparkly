<?php

namespace Sparkly\Framework\Foundation\Providers;

use Closure;
use Sparkly\Framework\Foundation\Application;

abstract class ServiceProvider
{
    protected Application $app;

    /** @var array<Closure> $bootCallbacks  */
    protected array $bootCallbacks = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Closure $callback
     * @return void
     */
    public function callback(Closure $callback): void
    {
        $this->bootCallbacks[] = $callback;
        
        if ($this->app->isBooted()) {
            $callback($this->app);
        }
    }

    public function callBootCallbacks(): void
    {
        $index = 0;

        while ($index < count($this->bootCallbacks)) {
            $this->bootCallbacks[$index]($this->app);
            $index++;
        }
    }

    abstract public function register(): void;
}
