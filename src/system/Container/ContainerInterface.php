<?php

namespace Sparkly\System\Container;

interface ContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id): mixed;

    /**
     * @param $id
     * @return bool
     */
    public function has($id): bool;
}