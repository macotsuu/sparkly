<?php

namespace Sparkly\Framework\Foundation;

use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Container\ContainerInterface;
use Sparkly\Framework\Foundation\Bootstrap\LoadConfigurationBootstrap;
use Sparkly\Framework\Foundation\Http\HttpKernel;
use Sparkly\Framework\Log\Logger;
use Sparkly\Framework\Routing\Router;

class Kernel extends Container
{
    private string $projectDir;
    private bool $bootstrapped = false;
    private array $bootstraps = [
        LoadConfigurationBootstrap::class
    ];

    public function bootstrap(): void
    {
        $this->registerCoreAliases();
        $this->registerBaseBinding();

        foreach ($this->bootstraps as $bootstrapper) {
            try {
                $this->make($bootstrapper)
                    ->setApplication($this)
                    ->boot();
            } catch (\ReflectionException) {
            }
        }

        $this->bootstrapped = true;
    }

    public function isBootstrapped(): bool
    {
        return $this->bootstrapped;
    }

    public function getProjectDir(): string
    {
        if (!isset($this->projectDir)) {
            $r = new \ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new LogicException(
                    sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name)
                );
            }

            $dir = $rootDir = dirname($dir);
            while (!is_file($dir . '/composer.json')) {
                if ($dir === dirname($dir)) {
                    return $this->projectDir = $rootDir;
                }
                $dir = dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir() . '/var/logs/';
    }

    public function getThemeDir(): string
    {
        return $this->getProjectDir() . '/app/custom/theme/';
    }

    public function getPluginDir(): string
    {
        return $this->getProjectDir() . '/app/custom/plugins/';
    }

    public function getConfigDir(): string
    {
        return $this->getProjectDir() . '/app/config/';
    }

    private function registerBaseBinding(): void
    {
        $this['app'] = $this;
        $this[Container::class] = $this;

        $this->bind(Router::class, fn() => new Router($this));
    }

    private function registerCoreAliases(): void
    {
        foreach (
            [
                'app' => [Container::class, ContainerInterface::class],
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
}
