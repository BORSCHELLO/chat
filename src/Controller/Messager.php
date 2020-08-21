<?php

namespace App\Controller;

use App\Room\Entity\Message;
use App\User\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\User\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Room\Repository\MessageRepository;
use App\Room\Repository\MessageRepositoryInterface;

class Messager extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @param $request
     */
    public function messager(Request $request,
    UserRepositoryInterface $userRepository,
    MessageRepositoryInterface $messageRepository)
    {
        $session=new Session();
        $message = new Message();
        $message->setMessage('');
        $formMessage = $this->createFormBuilder($message)
            ->add('message', TextareaType::class,
                array('attr' => array('class' => "form-control")))
            ->add('save', SubmitType::class,
                array('label' => 'Отправить', 'attr' => array('class' => "btn btn-success mt-2")))
            ->getForm();
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid() ) {
            $userName = $userRepository->findById($session->get('user'));
             $message->setUser($userName);
             $message->setCreatedAt(date('Y-m-d H:i:s',time()));

             $messageRepository->create($formMessage->getData());

            return $this->redirectToRoute('main');
        }
            $messageShow=$messageRepository->findByAll();
        return $this->render('main.html.twig',array('messages'=>$messageShow,'formMessage' => $formMessage->createView()));
    }
}
