<?php

namespace Volcano\Configuration;

class Configuration
{
    /** @var Paths $paths */
    private Paths $paths;

    /** @var array<string, mixed> $settings */
    private array $settings = [];

    /** @var array<Configuration> $instances */

    public function __construct()
    {
        $this->settings = array_merge(
            $_ENV,
            $_SERVER
        );

        $this->paths = new Paths();
    }

    public function path(): Paths
    {
        return $this->paths;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->settings[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }

        return null;
    }
}
