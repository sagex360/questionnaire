<?php

namespace App\Http\Controller\Secure;

use App\Converter\DtoConverter;
use App\Dto\Form\FormDto;
use App\Entity\Form;
use App\Message\Command\Form\CreateFormCommand;
use App\Message\Query\Form\FindFormsQuery;
use App\Message\Query\Form\GetFormRatioQuery;
use App\Message\Query\Form\GetResponseCountPerFormQuery;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Enum\SerializationGroupEnum;
use App\Enum\HttpMetaKeyEnum;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * @Rest\Route(path="/secure/form")
 */
class FormController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $queryBus;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $queryBus, MessageBusInterface $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Rest\Get(path="")
     *
     * @Rest\QueryParam(name=HttpMetaKeyEnum::LIMIT, requirements="\d+", strict=true, default=15)
     * @Rest\QueryParam(name=HttpMetaKeyEnum::OFFSET, requirements="\d+", nullable=true, default=0, strict=true)
     *
     * @Rest\View(serializerGroups={SerializationGroupEnum::LIST})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return Form[]
     */
    public function getListAction(ParamFetcherInterface $paramFetcher)
    {
        $envelope = $this->queryBus->dispatch(new FindFormsQuery($paramFetcher->all(true)));
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }

    /**
     * @Rest\Get(path="/{id}")
     *
     * @Rest\View(serializerGroups={SerializationGroupEnum::SECURE_VIEW})
     *
     * @param Form $form
     * @return Form
     */
    public function viewAction(Form $form)
    {
        return $form;
    }

    /**
     * @Rest\Get(path="/statistics/ratio")
     *
     * @Rest\View
     */
    public function getFormRatioAction()
    {
        $envelope = $this->queryBus->dispatch(new GetFormRatioQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }

    /**
     * @Rest\Get(path="/statistics/response-count")
     *
     * @Rest\View
     */
    public function getResponseCountPerFormAction()
    {
        $envelope = $this->queryBus->dispatch(new GetResponseCountPerFormQuery());
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }

    /**
     * @Rest\Post(path="")
     *
     * @OA\Parameter(
     *     name="body",
     *     in="path",
     *     required=true,
     *     @Model(type=FormDto::class),
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
     * @return array
     */
    public function createAction(Request $request, DtoConverter $dtoConverter)
    {
        $command = new CreateFormCommand(
            Uuid::uuid4()->toString(),
            $dtoConverter->convertToDto(FormDto::class, $request->request->all()),
        );
        $this->commandBus->dispatch($command);

        return [
            'id' => $command->getId(),
        ];
    }
}
