<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\SerializationGroupEnum;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 */
class FormResponse
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
     * @var Collection<Answer>
     *
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="formResponse", cascade={"persist"})
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private Collection $answers;

    /**
     * @var Form
     *
     * @ORM\ManyToOne(targetEntity=Form::class, inversedBy="responses")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Form $form;

    public function __construct(string $id, Form $form)
    {
        $this->id = $id;
        $this->form = $form;

        $this->answers = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Collection<Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(string $id, FormQuestion $question, string $answer): Answer
    {
        $answer = new Answer($id, $answer, $question, $this);
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }

        return $answer;
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }
}
