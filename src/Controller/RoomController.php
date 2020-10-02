<?php

namespace App\Controller;

use App\Response\Room\MessagesJsonResponse;
use App\Room\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $formMessage =$this->createForm(MessageForm::class, $message,['attr' => ['id' => 'message_form']]);
        $formMessage->handleRequest($request);

        if ($request->request->get('nowSend')) {
            $limitNowSend=$request->request->get('nowSend');
            $message->setUser($this->getUser());
            $message->setMessage($request->request->get('message'));
            $messageRepository->create($formMessage->getData());

            return new MessagesJsonResponse($messageRepository->getMessages(0, $limitNowSend));
        }

        return $this->render('main.html.twig', ['formMessage' => $formMessage->createView()]);
    }

    /**
     * @Route("/show", name="show")
     */
    public function show(MessageRepositoryInterface $messageRepository)
    {
        $messagesLimit = $_ENV['SHOW_MESSAGE_LIMIT'];

        return new MessagesJsonResponse($messageRepository->getMessages(0, $messagesLimit)->sort());
    }

    /**
     * @Route("/showTimer", name="showTimer")
     */
    public function showTimerMessage(Request $request,MessageRepositoryInterface $messageRepository)
    {
        return new MessagesJsonResponse($messageRepository->getMessagesByLastId($request->request->get('id')));
    }

    /**
     * @Route("/showMore", name="showMore")
     * @param $request
     */
    public function showMore(Request $request,MessageRepositoryInterface $messageRepository)
    {
        $messagesLimit = $_ENV['SHOW_MESSAGE_LIMIT'];
        $offset=$messagesLimit+$request->request->get('counterLimit');
        $limit=$request->request->get('limit');

        return new MessagesJsonResponse($messageRepository->getMessages($offset,$limit));
    }
}