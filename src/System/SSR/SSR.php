<?php

namespace Sparkly\System\SSR;

use Sparkly\System\SSR\Engine\EngineInterface;
use Sparkly\System\SSR\Exception\EngineException;

class SSR
{
    private EngineInterface $engine;
    private string $entry;

    public function withEngine(EngineInterface $engine): self
    {
        $this->engine = $engine;
        return $this;
    }

    public function withEntry(string $entry): self
    {
        $this->entry = $entry;
        return $this;
    }

    public function render() {
        try {
            $script = implode(';', [
                $this->dispatchScript(),
                $this->applicationScript()
            ]);

            $result = $this->engine->run($script);
        } catch (EngineException) {

        }

        $decoded = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        return $result;
    }

    private function dispatchScript(): string {
        return <<<JS"
            var dispatch = function (result) {
            return {$this->engine->getDispatcher()}(JSON.stringify(result))
        JS";
    }

    private function applicationScript(): string {
        return file_get_contents($this->entry);
    }
}