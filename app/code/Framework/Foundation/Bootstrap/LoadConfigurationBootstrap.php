<?php

namespace Sparkly\Framework\Foundation\Bootstrap;

use Sparkly\Framework\Config\Registry;
use Sparkly\Framework\Foundation\Kernel;

final class LoadConfigurationBootstrap extends Bootstrap
{
    public function boot(): void
    {
        $this->app['config'] = new Registry();

        foreach ($this->lookupForConfigurationFiles() as $key => $file) {
            $this->app['config']->set($key, require $file);
        }
    }

    private function lookupForConfigurationFiles(): array
    {
        $configurationFiles = [];

        foreach (new \DirectoryIterator($this->app[Kernel::class]->getConfigDir()) as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }

            $filename = explode('.', $file->getFilename());
            $configurationFiles[array_shift($filename)] = $file->getPathname();
        }
        return $configurationFiles;
    }
}
