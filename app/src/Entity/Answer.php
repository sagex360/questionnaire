<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Enum\SerializationGroupEnum;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private string $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private string $answer;

    /**
     * @var FormQuestion
     *
     * @ORM\ManyToOne(targetEntity=FormQuestion::class)
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private FormQuestion $question;

    /**
     * @var FormResponse
     *
     * @ORM\ManyToOne(targetEntity=FormResponse::class)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private FormResponse $formResponse;

    public function __construct(string $id, string $answer, FormQuestion $question, FormResponse $formResponse)
    {
        $this->id = $id;
        $this->answer = $answer;
        $this->question = $question;
        $this->formResponse = $formResponse;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @return FormQuestion
     */
    public function getQuestion(): FormQuestion
    {
        return $this->question;
    }

    /**
     * @return FormResponse
     */
    public function getFormResponse(): FormResponse
    {
        return $this->formResponse;
    }
}
