<?php

namespace App\Event\ObjectEvent;

use Symfony\Contracts\EventDispatcher\Event;

interface RaiseEventsInterface
{
    /**
     * Return events raised by the entity and clear those.
     *
     * @return Event[]
     */
    public function popEvents(): array;
}
