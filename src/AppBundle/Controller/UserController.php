<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/profil", name="app_user_profil")
     */
    public function profilAction()
    {
        return $this->render('user/profil.html.twig');
    }

    /**
     * @Route("/register", name="app_user_register")
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('app.manager.user');
        $user        = $userManager->createUser();
        $form        = $this->createForm('app_user_register', $user);

        $form->add('send', 'submit');

        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager->updateUserAndEncodePassword($user);

            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
