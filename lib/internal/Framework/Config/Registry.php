<?php

namespace Sparkly\Core\HttpKernel\Config;

class Registry
{
    protected array $data;

    public function set(string $key, mixed $value): self
    {
        $items = &$this->data;

        foreach (explode('.', $key) as $segment) {
            if (!isset($items[$segment]) || !is_array($items[$segment])) {
                $items[$segment] = [];
            }

            $items = &$items[$segment];
        }

        $items = $value;

        return $this;
    }

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $items = $this->data;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($items) || !$this->exists($items, $segment)) {
                return $default;
            }

            $items = &$items[$segment];
        }

        return $items;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}
