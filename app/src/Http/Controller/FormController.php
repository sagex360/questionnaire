<?php

namespace App\Http\Controller;

use App\Entity\Form;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Enum\SerializationGroupEnum;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Rest\Route(path="/form")
 */
class FormController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/{id}")
     *
     * @OA\Response(
     *     response=200,
     *     description="",
     *     @Model(type=Form::class, groups={SerializationGroupEnum::VIEW})
     * )
     *
     * @Rest\View(serializerGroups={SerializationGroupEnum::VIEW})
     *
     * @param Form $form
     * @return Form
     */
    public function viewAction(Form $form)
    {
        return $form;
    }
}
