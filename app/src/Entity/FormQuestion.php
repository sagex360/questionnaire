<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Enum\SerializationGroupEnum;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class FormQuestion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid", unique=true)
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::VIEW,
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
     *     SerializationGroupEnum::VIEW,
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private string $question;

    /**
     * @var Form
     *
     * @ORM\ManyToOne(targetEntity=Form::class, inversedBy="questions")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Form $form;

    public function __construct(string $id, string $question, Form $form)
    {
        $this->id = $id;
        $this->question = $question;
        $this->form = $form;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }
}
