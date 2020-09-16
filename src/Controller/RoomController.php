<?php

namespace App\Controller;

use App\Room\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Room\Repository\MessageRepositoryInterface;
use App\Room\Form\MessageForm;

class RoomController extends AbstractController
{
    public const ROUTE_MAIN = 'main';

    /**
     * @Route("/main", name="main")
     * @param $request
     */
    public function messager(Request $request, MessageRepositoryInterface $messageRepository)
    {
        $message = new Message();
        $message->setMessage('');
        $formMessage =$this->createForm(MessageForm::class, $message);
        $formMessage->handleRequest($request);

        if ($formMessage->isSubmitted() && $formMessage->isValid()) {
            $message->setUser($this->getUser());

            $messageRepository->create($formMessage->getData());

            return $this->redirectToRoute(self::ROUTE_MAIN);
        }
        $messageShow = $messageRepository->findByAll();
        return $this->render('main.html.twig',
            array('messages' => $messageShow, 'formMessage' => $formMessage->createView()));
    }
}
