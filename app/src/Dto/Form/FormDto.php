<?php

namespace App\Dto\Form;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

class FormDto
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var QuestionDto[]
     *
     * @Assert\Type(type="array")
     * @Assert\NotBlank
     */
    private $questions;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return FormDto
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return QuestionDto[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param QuestionDto[] $questions
     * @return FormDto
     */
    public function setQuestions($questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    public function addQuestion(QuestionDto $dto): self
    {
        $this->questions[] = $dto;

        return $this;
    }
}
