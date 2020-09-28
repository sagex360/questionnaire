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
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Rest\Route(path="/response")
 */
class FormResponseController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(path="")
     *
     * @OA\Parameter(
     *     name="body",
     *     in="path",
     *     required=true,
     *     @Model(type=FormResponseDto::class),
     * )
     * @OA\Response(
     *     response=200,
     *     description="",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="id", type="string")
     *     )
     * )
     *
     * @Rest\View
     *
     * @param Request $request
     * @param DtoConverter $dtoConverter
     * @param MessageBusInterface $commandBus
     * @return array
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
