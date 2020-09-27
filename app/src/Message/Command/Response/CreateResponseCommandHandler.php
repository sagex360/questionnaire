<?php

namespace App\Message\Command\Response;

use App\Factory\Entity\FormResponseFactory;
use App\Repository\Doctrine\FormResponseRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateResponseCommandHandler implements MessageHandlerInterface
{
    /**
     * @var FormResponseRepository
     */
    private FormResponseRepository $repository;

    /**
     * @var FormResponseFactory
     */
    private FormResponseFactory $factory;

    public function __construct(FormResponseRepository $repository, FormResponseFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function __invoke(CreateResponseCommand $command)
    {
        $this->repository->save(
            $this->factory->create($command->getId(), $command->getData())
        );
    }
}
