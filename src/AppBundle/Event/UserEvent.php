<?php

namespace AppBundle\Event;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserEvent extends Event
{
    const REGISTRATION_SUCCESS   = 'user.registration.completed';
    const REGISTRATION_CONFIRMED = 'user.registration.confirmed';

    private $request;
    private $user;

    public function __construct(UserInterface $user, Request $request)
    {
        $this->user    = $user;
        $this->request = $request;
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
