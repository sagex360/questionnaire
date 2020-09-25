<?php

namespace App\Service;

use App\Exception\ValidationHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $data): void
    {
        $violations = $this->validator->validate($data);
        if ($violations->count()) {
            throw new ValidationHttpException($violations);
        }
    }
}
