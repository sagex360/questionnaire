<?php

namespace App\Http\Controller\Secure;

use App\Converter\DtoConverter;
use App\Dto\Form\FormDto;
use App\Message\Form\CreateFormCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @Rest\Route(path="/secure/form")
 */
class FormController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Rest\Post(path="")
     *
     * @Rest\View
     *
     * @param Request $request
     * @param DtoConverter $dtoConverter
     */
    public function postAction(Request $request, DtoConverter $dtoConverter)
    {
        $this->commandBus->dispatch(new CreateFormCommand(
            Uuid::uuid4()->toString(),
            $dtoConverter->convertToDto(FormDto::class, $request->request->all()),
        ));
    }
}
