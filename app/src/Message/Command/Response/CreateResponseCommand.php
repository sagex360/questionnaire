<?php

namespace App\Message\Command\Response;

use App\Dto\Response\FormResponseDto;
use App\Message\AsyncMessageInterface;
use App\Message\ValidatableCommandInterface;

class CreateResponseCommand implements ValidatableCommandInterface, AsyncMessageInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var FormResponseDto
     */
    private FormResponseDto $data;

    public function __construct(string $id, FormResponseDto $data)
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
     * @return FormResponseDto
     */
    public function getData(): FormResponseDto
    {
        return $this->data;
    }

    public function getDataToValidate(): object
    {
        return $this->data;
    }
}
