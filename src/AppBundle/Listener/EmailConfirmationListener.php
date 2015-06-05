<?php

namespace AppBundle\Listener;

use AppBundle\Event\UserEvent;
use AppBundle\Helper\TokenGeneratorInterface;
use AppBundle\Manager\UserManager;
use AppBundle\Service\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;

class EmailConfirmationListener implements EventSubscriberInterface
{
    private $mailer;

    private $manager;

    private $tokenGenerator;

    public function __construct(MailerService $mailer, UserManager $userManager, TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailer         = $mailer;
        $this->manager        = $userManager;
        $this->tokenGenerator = $tokenGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserEvent::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        ];
    }

    public function onRegistrationSuccess(UserEvent $event)
    {
        $user = $event->getUser();

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
            $this->manager->save($user);
        }

        $this->mailer->sendConfirmationEmailMessage($user);
    }
}
