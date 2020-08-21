<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class Logout extends AbstractController
{
    /**
     *@Route("/logout", name="logout")
     */
    public function logout()
    {
        $session=new Session();
        $session->remove('user');
        return $this->redirectToRoute('login');
    }
}