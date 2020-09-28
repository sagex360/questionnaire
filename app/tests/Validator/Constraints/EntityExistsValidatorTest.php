<?php

namespace App\Tests\Validator\Constraints;

use App\Entity\Form;
use App\Tests\AbstractKernelTestCase;
use App\Validator\Constraints\EntityExists;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityExistsValidatorTest extends AbstractKernelTestCase
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = self::$container->get('validator');
    }

    /**
     * @test
     */
    public function shouldValidateEmptyValue()
    {
        $errors = $this->validator->validate(
            null,
            new EntityExists(['class' => Form::class])
        );

        $this->assertEquals(0, $errors->count());
    }

    /**
     * @test
     */
    public function shouldValidateValidValue()
    {
        $form = $this->entityManager->getRepository(Form::class)->findOneBy([]);

        $errors = $this->validator->validate(
            $form->getId(),
            new EntityExists(['class' => Form::class])
        );

        $this->assertEquals(0, $errors->count());
    }

    /**
     * @test
     */
    public function shouldReturnValidationErrors()
    {
        $errors = $this->validator->validate(
            0,
            new EntityExists(['class' => Form::class])
        );

        $this->assertGreaterThan(0, $errors->count());
        $this->assertEquals(EntityExists::ENTITY_NOT_FOUND, $errors->get(0)->getCode());
    }
}
