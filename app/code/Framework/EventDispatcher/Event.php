<?php

namespace Sparkly\Framework\EventDispatcher;

class Event
{
    private bool $propagationStopped = false;


    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }


    /**
     * @return void
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
