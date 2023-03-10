<?php

namespace Sparkly\Framework\Foundation\Kernel\Bootstrap;

use Sparkly\Framework\Foundation\Application;

final class LoadBundles
{
    public function boot(Application $app): void
    {
        $bundles = $app['config']->get('app.bundles') ?? [];

        foreach ($bundles as $bundle) {
            $app->register($bundle);
        }
    }
}
