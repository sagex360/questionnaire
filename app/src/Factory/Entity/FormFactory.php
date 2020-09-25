<?php

namespace App\Factory\Entity;

use App\Dto\Form\FormDto;
use App\Entity\Form;
use Ramsey\Uuid\Uuid;

class FormFactory
{
    public static function createFromFormDto(string $id, FormDto $dto): Form
    {
        $form = new Form($id, $dto->getName());
        foreach ($dto->getQuestions() as $questionDto) {
            $form->addQuestion(Uuid::uuid4()->toString(), $questionDto->getQuestion());
        }

        return $form;
    }
}
