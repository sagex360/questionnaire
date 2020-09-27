<?php

namespace App\Message\Command\Form;

use App\Factory\Entity\FormFactory;
use App\Repository\Doctrine\FormRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateFormCommandHandler implements MessageHandlerInterface
{
    /**
     * @var FormRepository
     */
    private FormRepository $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateFormCommand $command)
    {
        $form = FormFactory::createFromFormDto($command->getId(), $command->getData());

        $this->repository->save($form);
    }
}
