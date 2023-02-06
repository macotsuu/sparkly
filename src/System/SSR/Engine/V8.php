<?php

namespace Sparkly\System\SSR\Engine;

use Sparkly\System\SSR\Exception\EngineException;

class V8 implements EngineInterface
{
    public function __construct(private readonly \V8Js $v8) {}

    public function run(string $script): string {
        try {
            ob_start();
            $this->v8->executeString($script);
            return ob_get_contents();
        } catch (\V8JsScriptException $exception) {
            throw new EngineException($exception);
        } finally {
            ob_get_clean();
        }
    }

    public function getDispatcher(): string {
        return 'print';
    }
}