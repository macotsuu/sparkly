<?php

namespace Sparkly\Core\EventDispatcher;

final readonly class EventDispatcher
{
    public function __construct(private ListenerProvider $provider)
    {
    }

    /**
     * @param Event $event
     * @param string|null $name
     * @return Event
     */
    public function dispatch(Event $event, string $name = null): Event
    {
        $name ??= $event::class;

        foreach ($this->provider->getListenersForEvent($name) as $listener) {
            $listener($event);
        }

        return $event;
    }
}
