<?php

namespace Sparkly\System\SSR\Engine;

use Sparkly\System\SSR\Exception\EngineException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Node implements EngineInterface
{

    public function __construct(
        protected string $nodePath,
        protected string $tempPath
    ) {
    }

    public function run(string $script): string
    {
        $tempFilePath = $this->createTempFilePath();

        file_put_contents($tempFilePath, $script);

        $command = "{$this->nodePath} {$tempFilePath}";
        $process = Process::fromShellCommandline($command);

        try {
            return substr($process->mustRun()->getOutput(), 0, -1);
        } catch (ProcessFailedException $exception) {
            throw new EngineException($exception);
        } finally {
            unlink($tempFilePath);
        }
    }

    protected function createTempFilePath(): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [$this->tempPath, md5(intval(microtime(true) * 1000) . random_bytes(5)) . '.js']
        );
    }

    public function getDispatcher(): string
    {
        return 'console.log';
    }

}