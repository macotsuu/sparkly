<?php

namespace Sparkly\Framework\Container;

use Closure;
use Psr\Container\ContainerInterface as BaseContainerInterface;

interface ContainerInterface extends BaseContainerInterface
{
    /**
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     */
    public function alias(string $abstract, string $alias): void;

    /**
     * @param string $abstract
     * @param Closure|string|null $concrete
     * @return void
     */
    public function bind(string $abstract, Closure|string|null $concrete = null): void;
}
