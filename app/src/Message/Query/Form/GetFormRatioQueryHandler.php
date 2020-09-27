<?php

namespace App\Message\Query\Form;

use App\Repository\Doctrine\FormRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetFormRatioQueryHandler implements MessageHandlerInterface
{
    /**
     * @var FormRepository
     */
    private FormRepository $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetFormRatioQuery $query)
    {
        return $this->repository->getFormRatio();
    }
}
