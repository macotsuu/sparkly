<?php

namespace Sparkly\System\Application;

use Sparkly\Administration\Administration;
use Sparkly\Storefront\Storefront;
use Sparkly\System\Container\Container;
use Sparkly\System\Container\ContainerInterface;
use Sparkly\System\Http\Request;
use Sparkly\System\Routing\Router;
use Throwable;

class ApplicationLoader
{
    /** @var array<Application> $applications */
    private array $applications = [
        Administration::class,
        Storefront::class
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?: new Container();
    }

    public function load(): void
    {
        foreach ($this->applications as $application) {
            $instance = new $application();
            $instance->setContainer($this->container);
            $instance->boot();
        }
    }

    public function run(): void
    {
        $request = new Request();

        try {
            $this->container
                ->get(Router::class)
                ->dispatch($request)
                ->respond();
        } catch (Throwable $exception) {
            echo '<pre>';
            echo $exception->getMessage() . PHP_EOL;
            echo $exception->getTraceAsString() . PHP_EOL;
            echo '</pre>';
        }
    }
}
