<?php

namespace AppBundle\Security\Handler;

use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

class LoginSuccessHandler extends DefaultAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $httpUtils;

    private $userManager;

    private $authorizationChecker;

    public function __construct(HttpUtils $httpUtils, AuthorizationCheckerInterface $authorizationChecker, UserManager $userManager)
    {
        $this->httpUtils            = $httpUtils;
        $this->authorizationChecker = $authorizationChecker;
        $this->userManager          = $userManager;
    }
    
    /**
     * @inheritdoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $this->userManager->updateLastConnection($user, $request->getClientIp());
        }

        return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }

}
