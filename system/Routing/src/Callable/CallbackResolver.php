<?php

namespace Volcano\Routing\Callable;

use RuntimeException;

final class CallbackResolver
{
    /**
     * @param mixed $toResolve
     * @return Callback
     */
    public function resolve(mixed $toResolve): Callback
    {
        $resolved = $this->prepareToResolve($toResolve);

        return new Callback(
            $resolved[0],
            $resolved[1] ?: '__invoke'
        );
    }

    /**
     * @param mixed $toResolve
     * @return array
     */
    private function prepareToResolve(mixed $toResolve): array
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
