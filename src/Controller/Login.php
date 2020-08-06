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
                $form = $this->createFormBuilder($user)
            ->add('name', TextType::class,
                array('attr' => array('class' => "form-control")))
            ->add('save', SubmitType::class,
                array('label' => 'Отправить', 'attr' => array('class' => "btn btn-success mt-2")))
            ->getForm();
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() ) {
                $requestUser = $form->getData();
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['name' => $requestUser-> getName ()]);
                if($user){
                    $this->addFlash('success','С возвращением'.' '.$requestUser->getName());
                    $session->set('user', $user->getId());
                    return $this->redirectToRoute('main');
                }else{
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($requestUser);
                    $this->addFlash('success','Вы удачно зарегистрированы'.' '.$requestUser->getName());
                    $em->flush();
                    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['name' => $requestUser-> getName ()]);
                    $session->set('user', $user->getId());
                    return $this->redirectToRoute('main');
                }
        }
            return $this->render('login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *@Route("/main", name="main")
     */
    public function main()
    {
        return $this->render('main.html.twig');
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
