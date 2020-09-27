<?php

namespace App\Factory\Entity;

use App\Dto\Response\AnswerDto;
use App\Dto\Response\FormResponseDto;
use App\Entity\FormQuestion;
use App\Entity\FormResponse;
use App\Repository\Doctrine\FormQuestionRepository;
use App\Repository\Doctrine\FormRepository;
use Ramsey\Uuid\Uuid;

class FormResponseFactory
{
    /**
     * @var FormRepository
     */
    private FormRepository $formRepository;

    /**
     * @var FormQuestionRepository
     */
    private FormQuestionRepository $formQuestionRepository;

    public function __construct(FormRepository $formRepository, FormQuestionRepository $formQuestionRepository)
    {
        $this->formRepository = $formRepository;
        $this->formQuestionRepository = $formQuestionRepository;
    }

    public function create(string $id, FormResponseDto $dto): FormResponse
    {
        $questionIds = array_map(fn(AnswerDto $answerDto) => $answerDto->getQuestion(), $dto->getAnswers());
        $questions = $this->formQuestionRepository->findByIds($questionIds);
        $questions = array_combine(
            array_map(fn(FormQuestion $question) => $question->getId(), $questions),
            $questions,
        );

        $formResponse = new FormResponse($id, $this->formRepository->find($dto->getForm()));
        foreach ($dto->getAnswers() as $answerDto) {
            $formResponse->addAnswer(Uuid::uuid4(), $questions[$answerDto->getQuestion()], $answerDto->getAnswer());
        }

        return $formResponse;
    }
}
