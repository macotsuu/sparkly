<?php

namespace Volcano\Cache\Adapter;

interface AdapterInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key, mixed $value, int $ttl): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;
}