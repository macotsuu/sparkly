<?php

namespace Sparkly\System\SSR\Engine;

interface EngineInterface
{

    public function run(string $script): string;
    public function getDispatcher(): string;
}