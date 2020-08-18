<?php

namespace App\Controller;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\User\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class Service extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @param $request
     */
    public function messager(Request $request)
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
            $userName = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $session->get('user')]);
             $message->setUser($userName);
             $message->setCreatedAt(date('Y-m-d H:i:s',time()));
            $requestMessage = $formMessage->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($requestMessage);
                $em->flush();
            return $this->redirectToRoute('main');
        }
        $messageShow=$this->getDoctrine()->getRepository(Message::class)->findAll();
        return $this->render('main.html.twig',array('messages'=>$messageShow,'formMessage' => $formMessage->createView()));
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
