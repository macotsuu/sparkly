<?php

namespace Volcano\Foundation;

use Exception;
use ReflectionException;
use system\Container\Container;
use Volcano\Foundation\Providers\ConfigurationServiceProvider;
use Volcano\Foundation\Providers\RoutingServiceProvider;
use Volcano\Foundation\Providers\ServiceProvider;
use Volcano\Http\Request;
use Volcano\Http\Response;
use Volcano\Routing\RouteCollector\RouteCollectorProxy;
use Volcano\Routing\Router;

class Application extends RouteCollectorProxy
{
    private bool $booted = false;
    /** @var string $basePath */
    private string $basePath;
    /** @var array $settings */
    private array $settings = [];
    /** @var array $serviceProviders */
    private array $serviceProviders = [];
    /** @var Router $router */
    private readonly Router $router;

    public function __construct(string $basePath = null)
    {
        parent::__construct();

        if ($basePath) {
            $this->setBasePath($basePath);
        }

        $this->registerBaseServiceProviders();
    }

    /**
     * @param string $basePath
     * @return $this
     */
    public function setBasePath(string $basePath): self
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }

    private function registerBaseServiceProviders(): void
    {
        $this->register(new RoutingServiceProvider($this));
        $this->register(new ConfigurationServiceProvider($this));
    }

    /**
     * @param ServiceProvider $provider
     * @return void
     */
    private function register(ServiceProvider $provider): void
    {
        $this->serviceProviders[] = $provider;
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->isBooted()) {
            return;
        }

        array_walk($this->serviceProviders, function (ServiceProvider $p) {
            $p->boot();
        });

        $this->booted = true;
    }

    /**
     * @return bool
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * @return string
     */
    public function configPath(): string
    {
        return $this->basePath('config');
    }

    /**
     * @param string $path
     * @return string
     */
    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * @param string $url
     * @return string
     */
    public function publicPath(string $url): string
    {
        return $this->config('APP_URL') . $url;
    }

    /**
     * @param string $path
     * @return string
     */
    public function varPath(string $path = ''): string
    {
        return $this->basePath('var') . ($path != '' ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * @param string $className
     * @return mixed
     * @throws ReflectionException
     */
    public function make(string $className): mixed
    {
        return Container::getInstance()->make($className);
    }

    /**
     * @param string $key
     * @param mixed|null $value
     * @return mixed
     */
    public function config(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $this->settings[$key] = $value;
        }

        return $this->settings[$key];
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    protected function handle(Request $request): Response
    {
        return (new Router($this->routeCollector))->dispatch($request);
    }
}
