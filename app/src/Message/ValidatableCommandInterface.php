<?php

namespace App\Message;

interface ValidatableCommandInterface
{
    public function getDataToValidate(): object;
}
