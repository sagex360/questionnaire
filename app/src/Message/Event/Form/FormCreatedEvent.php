<?php

namespace App\Message\Event\Form;

use App\Entity\Form;
use App\Message\Event\Event;
use App\Message\SyncMessageInterface;

class FormCreatedEvent implements SyncMessageInterface, Event
{
    /**
     * @var Form
     */
    private Form $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }
}
