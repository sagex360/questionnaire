<?php

namespace App\Message\Form;

use App\Dto\Form\FormDto;
use App\Message\AsyncCommandInterface;
use App\Message\ValidatableCommandInterface;

class CreateFormCommand implements ValidatableCommandInterface, AsyncCommandInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var FormDto
     */
    private FormDto $data;

    public function __construct(string $id, FormDto $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return FormDto
     */
    public function getData(): FormDto
    {
        return $this->data;
    }

    public function getDataToValidate(): object
    {
        return $this->data;
    }
}
