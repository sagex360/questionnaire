<?php

namespace App\Entity;

use App\Event\ObjectEvent\RaiseEventsInterface;
use App\Event\ObjectEvent\RaiseEventsTrait;
use App\Message\Event\Form\FormCreatedEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Doctrine\FormRepository;
use App\Enum\SerializationGroupEnum;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=FormRepository::class)
 */
class Form implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::LIST,
     *     SerializationGroupEnum::VIEW,
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private string $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::LIST,
     *     SerializationGroupEnum::VIEW,
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private string $name;

    /**
     * @var Collection<FormQuestion>
     *
     * @ORM\OneToMany(targetEntity=FormQuestion::class, mappedBy="form", cascade={"persist"})
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::VIEW,
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private Collection $questions;

    /**
     * @var Collection<FormResponse>
     *
     * @ORM\OneToMany(targetEntity=FormResponse::class, mappedBy="form")
     *
     * @Serializer\Groups({
     *     SerializationGroupEnum::SECURE_VIEW,
     * })
     */
    private Collection $responses;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        $this->questions = new ArrayCollection();
        $this->responses = new ArrayCollection();

        $this->raise(new FormCreatedEvent($this));
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<FormQuestion>
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param string $id
     * @param string $question
     * @return FormQuestion
     */
    public function addQuestion(string $id, string $question): FormQuestion
    {
        $question = new FormQuestion($id, $question, $this);
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $question;
    }

    /**
     * @return Collection
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }
}
