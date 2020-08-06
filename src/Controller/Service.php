<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class Service extends AbstractController
{
    /**
     *@Route("/main", name="main")
     */
    public function main()
    {
        $session=new Session();
        $userName = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $session->get('user')]);
        return $this->render('main.html.twig',array('userName'=>$userName->getName()));
    }
    /**
     *@Route("#", name="logout")
     */
    public function logout()
    {
        $session=new Session();
        $session->remove('user');
        return $this->redirectToRoute('login');
    }
}