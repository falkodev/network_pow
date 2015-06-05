<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    /**
     * @Route("/profil", name="app_user_profil")
     */
    public function profilAction(Request $request)
    {
        $userManager = $this->get('app.manager.user');
        $user        = $this->getUser();
        $oldPassword = $user->getPassword();

        $form        = $this->createForm('app_user_profil', $user);

        $form->add('send', 'submit', [
            'label'              => 'profil.submit',
            'translation_domain' => 'user'
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var UserInterface $datas */
            $datas = $form->getData();

            if (null !== $datas->getPassword()) {
                $userManager->updateUserAndEncodePassword($user);
            } else {
                // Set old password
                $user->setPassword($oldPassword);
                $userManager->updateUser($user);
            }

            $this->addFlash('notice', $this->get('translator')->trans('form.confirm_update', [], 'user'));

            return $this->redirectToRoute('app_user_profil');
        }

        return $this->render('user/profil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register", name="app_user_register")
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('app.manager.user');
        $user        = $userManager->createUser();
        $form        = $this->createForm('app_user_register', $user);

        $form->add('send', 'submit', [
            'label'              => 'form.submit',
            'translation_domain' => 'user'
        ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager->updateLastConnection($user, $request->getClientIp(), false);
            $userManager->updateUserAndEncodePassword($user);

            $this->addFlash('notice', $this->get('translator')->trans('form.confirm_register', [], 'user'));

            // Loggin user
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
