<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $user = [
            "id" => $user->getId(),
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "email" => $user->getEmail(),
            "phone" => $user->getPhone(),
            "roles" => $user->getRoles(),
        ];
        $data['user'] = $user;

        $event->setData($data);
    }
}
