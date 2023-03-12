<?php

namespace Sparkly\Framework\Foundation;

use Exception;
use React\Http\HttpServer;
use React\Socket\SocketServer;
use ReflectionException;
use Sparkly\Framework\Container\Container;
use Sparkly\Framework\Foundation\Kernel\Kernel;
use Sparkly\Framework\Foundation\Providers\ServiceProvider;

class Application extends Container
{
    /** @var string $basePath */
    private string $basePath;

    /** @var array $serviceProviders */
    private array $serviceProviders = [];
    private Kernel $kernel;

    public function __construct()
    {
        $this->kernel = new Kernel($this);
    }

    /**
     * Start application
     * @return void
     * @throws ReflectionException
     */
    public function run(): void
    {
        if ($this->kernel->isBooted() === false) {
            $this->kernel->boot();
        }

        $server = new HttpServer($this->make('http.kernel'));
        $server->on('error', function (Exception|TypeError $e) {
            $this['logger']->error($e->getMessage());
            $this['logger']->error($e->getTraceAsString());
        })->listen(new SocketServer('0.0.0.0:8080'));
    }

    /**
     * @param Path $path
     * @return string
     */
    public function path(Path $path): string
    {
        if (!isset($this->basePath)) {
            $r = new \ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new LogicException(
                    sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name)
                );
            }

            $dir = $rootDir = dirname($dir);
            while (!is_file($dir . '/composer.json')) {
                if ($dir === dirname($dir)) {
                    return $this->basePath = $rootDir;
                }
                $dir = dirname($dir);
            }
            $this->basePath = $dir;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . $path->value;
    }

    /**
     * @param ServiceProvider|string $provider
     * @return ServiceProvider
     */
    public function register(ServiceProvider|string $provider): ServiceProvider
    {
        if (($registered = $this->getProvider($provider))) {
            return $registered;
        }
        
        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        $this->serviceProviders[] = $provider;

        if ($this->kernel->isBooted()) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * @param ServiceProvider $provider
     * @return void
     */
    public function bootProvider(ServiceProvider $provider): void
    {
        $provider->boot();
    }

    /**
     * @param ServiceProvider|string $name
     * @return ServiceProvider|null
     */
    public function getProvider(ServiceProvider|string $name): ServiceProvider|null
    {
        $name = is_string($name)
            ? $name
            : get_class($name);

        foreach ($this->serviceProviders as $provider) {
            if ($provider instanceof $name) {
                return $provider;
            }
        }

        return null;
    }

    /**
     * Get service providers
     * @return array<ServiceProvider>
     */
    public function getProviders(): array
    {
        return $this->serviceProviders;
    }
}
