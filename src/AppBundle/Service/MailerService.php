<?php

namespace AppBundle\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailerService
{
    private $mailer;

    private $router;

    private $templating;

    private $translator;

    private $parameters;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, EngineInterface $templating, TranslatorInterface $translator, array $parameters)
    {
        $this->mailer     = $mailer;
        $this->router     = $router;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $confirmationParameters = $this->parameters['confirmation'];

        $subject  = $this->translator->trans($confirmationParameters['subject'], [], 'user');
        $template = $confirmationParameters['template'];
        $url      = $this->router->generate('app_user_confirm', ['token' => $user->getConfirmationToken()], true);
        $body     = $this->templating->render($template, array(
            'user'            => $user,
            'confirmationUrl' => $url
        ));

        $this->sendEmailMessage($subject, $body, $this->parameters['from_email'], $user->getEmail());
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string|array $fromEmail
     * @param string|array $toEmail
     */
    protected function sendEmailMessage($subject, $body, $fromEmail, $toEmail)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
