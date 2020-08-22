<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{
    public const ROUTE_LOGIN = 'profile_login';

    /**
     *@Route("/profile/login", name="profile_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute(RoomController::ROUTE_MAIN);
        }

        return $this->render('login.html.twig');
    }

    /**
     *@Route("/profile/logout", name="profile_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('profile_login');
    }
}
