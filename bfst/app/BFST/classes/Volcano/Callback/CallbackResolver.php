<?php

namespace Volcano\Callback;

use RuntimeException;

final class CallbackResolver
{
    /**
     * @param string|callable|array $toResolve
     * @return Callback
     */
    public function resolve(string|callable|array $toResolve): Callback
    {
        $resolved = $this->prepareToResolve($toResolve);

        return new Callback(
            $resolved[0],
            $resolved[1] ?: '__invoke'
        );
    }

    /**
     * @param string|callable|array $toResolve
     * @return array
     */
    private function prepareToResolve(string|callable|array $toResolve): array
    {
        if (is_array($toResolve)) {
            [$class, $method] = $toResolve;
            if (!class_exists($class)) {
                if ($method) {
                    $class .= '::' . $method . '()';
                }

                throw new RuntimeException(sprintf('Callable %s does not exist', $class));
            }

            return [$class, $method];
        }

        return [$toResolve, null];
    }
}
