<?php
namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class Login extends AbstractController
{
    /**
     *@Route("/", name="login")
     */
    public function login(Request $request)
    {
        $session = new Session();
        $user = new User();
        $user->setName('');
                $formUser = $this->createFormBuilder($user)
            ->add('name', TextType::class,
                array('attr' => array('class' => "form-control")))
            ->add('save', SubmitType::class,
                array('label' => 'Отправить', 'attr' => array('class' => "btn btn-success mt-2")))
            ->getForm();
        $formUser->handleRequest($request);
            if ($formUser->isSubmitted() && $formUser->isValid() ) {
                $requestUser = $formUser->getData();
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['name' => $requestUser-> getName ()]);
                if($user){
                    $this->addFlash('success','С возвращением'.' '.$requestUser->getName());
                    $session->set('user', $user->getId());
                    $session->set('userName', $user->getName());
                    return $this->redirectToRoute('main');
                }else{
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($requestUser);
                    $this->addFlash('success','Вы удачно зарегистрированы'.' '.$requestUser->getName());
                    $em->flush();
                    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['name' => $requestUser-> getName ()]);
                    $session->set('user', $user->getId());
                    $session->set('userName', $user->getName());
                    return $this->redirectToRoute('main');
                }
        }
            return $this->render('login.html.twig', array(
            'formUser' => $formUser->createView()
        ));
    }
}

