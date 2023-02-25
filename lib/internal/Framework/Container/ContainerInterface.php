<?php

namespace Sparkly\Framework\Container;

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
}
