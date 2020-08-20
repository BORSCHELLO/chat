<?php

namespace App\Controller;

use App\User\Entity\User;
use App\User\Form\RegisterForm;
use App\User\Repository\UserRepositoryInterface;
use App\User\Service\RegisterUserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class Login extends AbstractController
{
    /**
     *@Route("/", name="login")
     */
    public function login(
        Request $request,
        UserRepositoryInterface $userRepository,
        RegisterUserServiceInterface $registerUserService
    ) {
        $user = new User();
        $user->setName('');

        $form = $this->createForm(RegisterForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formUser = $form->getData();
            $user = $userRepository->findByName($formUser->getName());

            if ($user !== null) {
                $this->addFlash('success', sprintf('С возвращением %s', $user->getName()));
            } else {
                $user = $registerUserService->register($formUser);
                $this->addFlash('success', sprintf('ы удачно зарегистрированы %s', $user->getName()));
            }

            $this->setUser($user);

            return $this->redirectToRoute('main');
        }

        return $this->render('login.html.twig', array(
            'formUser' => $form->createView()
        ));
    }

    protected function setUser(User $user)
    {
        $session = new Session();
        $session->set('user', $user->getId());
        $session->set('userName', $user->getName());
    }
}

