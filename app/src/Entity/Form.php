<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Doctrine\FormRepository;

/**
 * @ORM\Entity(repositoryClass=FormRepository::class)
 */
class Form
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", unique=true)
     */
    private string $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @var Collection<FormQuestion>
     *
     * @ORM\OneToMany(targetEntity=FormQuestion::class, mappedBy="form", cascade={"persist"})
     */
    private Collection $questions;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        $this->questions = new ArrayCollection();
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
}
