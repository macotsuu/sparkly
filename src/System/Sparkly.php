<?php

namespace Sparkly\System;

use Dotenv\Dotenv;
use Sparkly\System\Foundation\HttpKernel;

class Sparkly extends HttpKernel
{
    /** @var string $basePath */
    protected string $basePath;

    /** @var bool $booted */
    protected bool $booted = false;

    public function run(): void
    {
        if ($this->booted === false) {
            $this->boot();
        }

        $this->handle()->respond();
    }

    private function boot(): void
    {
        if ($this->booted === true) {
            return;
        }

        $this->setBasePath(SPARKLY_ROOT_DIR);
        $this->loadEnv();
        $this->loadRoutes($this->basePath . 'src/Sparkly/**/Resources/routes.php');
    }

    public function setBasePath(string $path): self
    {
        $this->basePath = $path;
        return $this;
    }

    private function loadEnv(): void
    {
        (Dotenv::createImmutable($this->basePath))->load();
    }
}