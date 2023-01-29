<?php

namespace Volcano\Container;

interface ContainerInterface
{
    public function get(string $id): mixed;

    public function has($id);
}