<?php

namespace App\Dto\Form;

use Symfony\Component\Validator\Constraints as Assert;

class QuestionDto
{
    /**
     * @var string
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     */
    private $question;

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     * @return QuestionDto
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }
}
