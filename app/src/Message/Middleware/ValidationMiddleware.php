<?php

namespace App\Message\Middleware;

use App\Message\ValidatableCommandInterface;
use App\Service\ValidationService;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class ValidationMiddleware implements MiddlewareInterface
{
    /**
     * @var ValidationService
     */
    private ValidationService $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $command = $envelope->getMessage();
        if ($command instanceof ValidatableCommandInterface) {
            $this->validationService->validate($command->getDataToValidate());
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
