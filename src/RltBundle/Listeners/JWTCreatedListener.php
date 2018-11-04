<?php

namespace RltBundle\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use RltBundle\Entity\User;

/**
 * Update JWT inner data for frontend.
 *
 * Class JWTCreatedListener.
 */
class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        /** @var User $user */
        $user = $event->getUser();
        $payload['id'] = $user->getId();
        $payload['username'] = $user->getUsername();

        $event->setData($payload);
    }
}
