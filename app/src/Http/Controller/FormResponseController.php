<?php

namespace App\Http\Controller;

use App\Converter\DtoConverter;
use App\Dto\Response\FormResponseDto;
use App\Message\Command\Response\CreateResponseCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @Rest\Route(path="/response")
 */
class FormResponseController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(path="")
     *
     * @Rest\View
     *
     * @param Request $request
     * @param DtoConverter $dtoConverter
     * @param MessageBusInterface $commandBus
     */
    public function createAction(Request $request, DtoConverter $dtoConverter, MessageBusInterface $commandBus)
    {
        $command = new CreateResponseCommand(
            Uuid::uuid4()->toString(),
            $dtoConverter->convertToDto(FormResponseDto::class, $request->request->all()),
        );
        $commandBus->dispatch($command);

        return [
            'id' => $command->getId(),
        ];
    }
}
