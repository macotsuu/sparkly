<?php

namespace BFST\Base;

use Volcano\Foundation\Application as HttpKernel;
use Volcano\Http\Request;
use Volcano\ORM\EntityManager;
use Volcano\ORM\EntityManagerInterface;

class Application extends HttpKernel
{
    public const VERSION = '0.1.0-alpha';

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->make(EntityManager::class);
    }

    public function run(): void
    {
        $this->handle(new Request())->respond();
    }

    public function version(): string
    {
        return self::VERSION;
    }
}