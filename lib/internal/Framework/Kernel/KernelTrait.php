<?php

namespace Sparkly\Framework\Kernel;

use LogicException;
use ReflectionObject;

trait KernelTrait
{
    public function getProjectDir(): string
    {
        if (!isset($this->projectDir)) {
            $r = new ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new LogicException(
                    sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name)
                );
            }

            $dir = $rootDir = dirname($dir);
            while (!is_file($dir . '/composer.json')) {
                if ($dir === dirname($dir)) {
                    return $this->projectDir = $rootDir;
                }
                $dir = dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir() . '/var/logs/';
    }

    public function getThemeDir(): string
    {
        return $this->getProjectDir() . '/app/custom/theme/';
    }
}
