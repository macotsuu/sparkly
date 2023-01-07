<?php

namespace Volcano\Database;

use RuntimeException;

class Entity
{
    public function get(string $prop): mixed
    {
        return $this->{$prop};
    }

    /**
     * @param string $prop
     * @param mixed $value
     * @return void
     * @throws RuntimeException
     */
    public function set(string $prop, mixed $value): void
    {
        if (!property_exists($this, $prop)) {
            throw new RuntimeException("Parametr $prop nie jest zdeklarowany w klasie Order");
        }

        $this->{$prop} = $value;
    }
}
