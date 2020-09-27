<?php

namespace App\Http\Controller;

use App\Entity\Form;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Enum\SerializationGroupEnum;

/**
 * @Rest\Route(path="/form")
 */
class FormController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/{id}")
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
