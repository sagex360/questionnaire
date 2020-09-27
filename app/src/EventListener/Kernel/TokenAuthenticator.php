<?php

namespace App\EventListener\Kernel;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TokenAuthenticator
{
    private const SECURE_ROUTE_PART = '/secure/';

    /**
     * @var string
     */
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __invoke(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (false === strpos($request->getRequestUri(), self::SECURE_ROUTE_PART)) {
            return;
        }

        if ($this->token !== $request->headers->get('app-token', '')) {
            throw new AccessDeniedException();
        }
    }
}
