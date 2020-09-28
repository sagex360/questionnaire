<?php

namespace App\Dto\Form;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;
use App\Entity\Form;

/**
 * @AppAssert\UniqueDto(fields={"name"}, mapToEntityClass=Form::class)
 */
class FormDto
{
    /**
     * @var string
     *
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
     * @Assert\Valid
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
