<?php

namespace Sparkly\Framework\Config;

class Registry
{
    /** @var array $data */
    protected array $data = [];

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
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
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $items = $this->data;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($items) || !$this->has($segment, $items)) {
                return $default;
            }
            $items = &$items[$segment];
        }

        return $items;
    }

    /**
     * @param string $key
     * @param array $items
     * @return bool
     */
    public function has(string $key, array $items): bool
    {
        return array_key_exists($key, $items);
    }
}
