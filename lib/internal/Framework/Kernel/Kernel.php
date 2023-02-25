<?php

namespace Sparkly\Framework\Kernel;

use Sparkly\Core\HttpKernel\HttpKernel;
use Sparkly\Core\Providers\LogServiceProvider;
use Sparkly\Core\Providers\RoutingServiceProvider;
use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Foundation\ServiceProvider;
use Sparkly\Framework\Log\Logger;
use Sparkly\Framework\Routing\Router;

class Kernel extends Container
{
    use KernelTrait;

    protected bool $booted = false;
    protected string $projectDir;
    protected array $providers = [];

    public function boot()
    {
        if ($this->booted === true) {
            return;
        }

        $this->registerCoreAliases();
        $this->registerBaseProviders();

        $this->booted = true;
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * @param ServiceProvider $provider
     * @return ServiceProvider
     */
    public function register(ServiceProvider $provider): ServiceProvider
    {
        if (isset($this->providers[$provider::class])) {
            return $this->providers[$provider::class];
        }

        $this->providers[$provider::class] = $provider;
        $this->providers[$provider::class]->boot();

        return $provider;
    }

    private function registerCoreAliases(): void
    {
        foreach (
            [
                'router' => [Router::class],
                'http.kernel' => [HttpKernel::class],
                'logger' => [Logger::class]
            ] as $key => $aliases
        ) {
            foreach ($aliases as $alias) {
                $this->alias($alias, $key);
            }
        }
    }

    private function registerBaseProviders(): void
    {
        $this->register(new LogServiceProvider($this));
        $this->register(new RoutingServiceProvider($this));
    }
}
