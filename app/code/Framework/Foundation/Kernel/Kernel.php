<?php

namespace Sparkly\Framework\Foundation\Kernel;

use ReflectionException;
use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Foundation\Application;
use Sparkly\Framework\Foundation\Kernel\Bootstrap\LoadConfiguration;
use Sparkly\Framework\Foundation\Kernel\Bootstrap\LoadBundles;
use Sparkly\Framework\Foundation\Kernel\Bootstrap\LoadEnvConfiguration;
use Sparkly\Framework\Foundation\Kernel\Bootstrap\SetupDatabase;
use Sparkly\Framework\Foundation\Kernel\Http\HttpKernel;
use Sparkly\Framework\Foundation\Kernel\Http\HttpKernelInterface;
use Sparkly\Framework\Log\Logger;
use Sparkly\Framework\Log\LoggerInterface;
use Sparkly\Framework\Routing\Router;

class Kernel
{
    /** @var bool $booted */
    private bool $booted = false;

    /** @var array|string[] $bootstraps */
    private array $bootstraps = [
        LoadEnvConfiguration::class,
        LoadConfiguration::class,
        SetupDatabase::class,
        LoadBundles::class,

    ];
    public function __construct(protected Application $app)
    {
    }

    /**
     * Bootstrap a application
     * @return void
     * @throws ReflectionException
     */
    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->registerBaseBinding();
        $this->registerCoreAliases();
        $this->callBootstraps();

        $serviceProviders = $this->app->getProviders();

        array_walk($serviceProviders, function ($provider) {
            $this->app->bootProvider($provider);
        });

        $this->booted = true;
    }

    /**
     * Check if application is "booted" state.
     * @return bool
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * @return void
     */
    private function registerBaseBinding(): void
    {
        $this->app['app'] = $this->app;
        $this->app[ContainerInterface::class] = $this->app;

        $this->app->bind(HttpKernelInterface::class, fn () => new HttpKernel($this->app));
        $this->app->bind(Router::class, fn() => new Router($this->app));
    }

    /**
     * @return void
     */
    private function registerCoreAliases(): void
    {
        foreach (
            [
                'app' => [self::class, Container::class, ContainerInterface::class],
                'router' => [Router::class],
                'http.kernel' => [HttpKernel::class, HttpKernelInterface::class],
                'logger' => [Logger::class, LoggerInterface::class]
            ] as $key => $aliases
        ) {
            foreach ($aliases as $alias) {
                $this->app->alias($alias, $key);
            }
        }
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    private function callBootstraps(): void
    {
        array_walk($this->bootstraps, function ($bootstrap) {
            $this->app->make($bootstrap)->boot($this->app);
        });
    }
}
