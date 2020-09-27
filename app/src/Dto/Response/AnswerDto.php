<?php

namespace App\Dto\Response;

use App\Annotation\ConvertUuidToEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\FormQuestion;
use App\Validator\Constraints as AppAssert;

class AnswerDto
{
    /**
     * @ConvertUuidToEntity(class=FormQuestion::class)
     *
     * @Assert\NotBlank
     * @Assert\Uuid
     * @AppAssert\EntityExists(class=FormQuestion::class)
     */
    private $question;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    private $answer;

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     * @return AnswerDto
     */
    public function setQuestion($question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     * @return AnswerDto
     */
    public function setAnswer($answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
