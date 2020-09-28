<?php

namespace App\Message\Event\Form;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FormCreatedEventHandler implements MessageHandlerInterface
{
    public function __invoke(FormCreatedEvent $event)
    {
        // do some job, for example, send Form to a fronted via ws
    }
}
