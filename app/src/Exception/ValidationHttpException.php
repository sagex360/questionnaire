<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationHttpException extends HttpException
{
    /** @var ConstraintViolationListInterface */
    private ConstraintViolationListInterface $errors;

    public function __construct(
        ConstraintViolationListInterface $errors,
        int $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY,
        string $message = null,
        Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->errors = $errors;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
