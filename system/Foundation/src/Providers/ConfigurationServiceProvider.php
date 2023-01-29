<?php

namespace Volcano\Foundation\Providers;

use Exception;

class ConfigurationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configuration(function ($files) {
            array_walk($files, function ($file) {
                $this->app->config(basename($file, '.php'), require $file);
            });
        });
    }

    /**
     * @param callable $callback
     * @return void
     */
    private function configuration(callable $callback): void
    {
        try {
            $callback(glob($this->app->configPath() . '/*.php'));
        } catch (Exception) {
        }
    }
}