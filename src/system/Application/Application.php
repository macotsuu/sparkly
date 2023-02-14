<?php

namespace Sparkly\System\Application;

use Sparkly\System\Container\ContainerInterface;

abstract class Application
{
    /** @var string $name */
    protected string $name;

    /**
     * @var ContainerInterface $container
     */
    protected ContainerInterface $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;
        return $this;
    }

    abstract public function boot(): void;
}
