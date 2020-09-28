<?php

namespace App\Event\ObjectEvent;

use App\Message\Event\Event;

trait RaiseEventsTrait
{
    /**
     * @var array
     */
    protected array $events = [];

    public function popEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }

    protected function raise(Event $event)
    {
        $this->events[] = $event;
    }
}
