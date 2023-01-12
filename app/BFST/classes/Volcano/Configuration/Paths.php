<?php

namespace Volcano\Configuration;

class Paths
{
    public string $app = BFST_DIR . 'app/';
    public string $var = BFST_DIR . 'var/';
    public string $core;
    public string $modules;
    public string $logs;

    public function __construct()
    {
        $this->logs = $this->var . 'logs/';
        $this->core = $this->app . 'BFST/';
        $this->modules = $this->core . 'modules/';
    }
}
