<?php

namespace Sparkly\System\SSR;

use Sparkly\System\SSR\Engine\EngineInterface;

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

    public function render(): string
    {
        $script = implode(';', [
            $this->dispatchScript(),
            $this->applicationScript()
        ]);

        $result = $this->engine->run($script);
        $decoded = json_decode($result, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $result;
    }

    private function dispatchScript(): string
    {
        return <<<JS
            const dispatch = result => {$this->engine->getDispatcher()}(result)
        JS;
    }

    private function applicationScript(): string {
        return file_get_contents($this->entry);
    }
}