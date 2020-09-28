<?php

namespace App\Dto\Response;

use App\Annotation\ConvertUuidToEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Form;
use App\Validator\Constraints as AppAssert;

class FormResponseDto
{
    /**
     * @var string|null
     *
     * @ConvertUuidToEntity(class=Form::class)
     *
     * @Assert\NotBlank
     * @Assert\Uuid
     * @AppAssert\EntityExists(class=Form::class)
     */
    private $form;

    /**
     * @var AnswerDto[]
     *
     * @Assert\Type(type="array")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    private $answers;

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param mixed $form
     * @return FormResponseDto
     */
    public function setForm($form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     * @return FormResponseDto
     */
    public function setAnswers($answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}
