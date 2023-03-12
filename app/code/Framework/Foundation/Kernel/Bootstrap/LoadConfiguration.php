<?php

namespace Sparkly\Framework\Foundation\Kernel\Bootstrap;

use Sparkly\Framework\Config\Registry;
use Sparkly\Framework\Foundation\Application;
use Sparkly\Framework\Foundation\Path;

final class LoadConfiguration
{
    public function boot(Application $app): void
    {
        $app['config'] = new Registry();

        foreach ($this->lookupForConfigurationFiles($app->path(Path::CONFIG_PATH)) as $key => $file) {
            $app['config']->set($key, require $file);
        }
    }

    /**
     * @param string $configPath
     * @return array
     */
    private function lookupForConfigurationFiles(string $configPath): array
    {
        $configurationFiles = [];

        foreach (new \DirectoryIterator($configPath) as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }

            $filename = explode('.', $file->getFilename());
            $configurationFiles[array_shift($filename)] = $file->getPathname();
        }
        return $configurationFiles;
    }
}
