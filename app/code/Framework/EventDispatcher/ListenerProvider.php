<?php

namespace Sparkly\Framework\EventDispatcher;

class ListenerProvider
{
    private array $listeners = [];

    /**
     * @param string $eventName
     * @return iterable
     */
    public function getListenersForEvent(string $eventName): iterable
    {
        if (array_key_exists($eventName, $this->listeners)) {
            return $this->listeners[$eventName];
        }

        return [];
    }

    /**
     * @param string $eventName
     * @param callable $callable
     * @return $this
     */
    public function addListener(string $eventName, callable $callable): self
    {
        $this->listeners[$eventName][] = $callable;

        return $this;
    }
}
