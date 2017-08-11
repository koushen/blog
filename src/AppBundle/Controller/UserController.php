<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;



class UserController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('AppBundle:User:login.html.twig', array(
        "error" => $error,
        "last_username" => $lastUsername
        ));

    }


    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository("AppBundle:Users");
            $userQ = $userRepo->findOneBy(array('email'=>$form->get('email')->getData()));
            if (count($userQ)==0){
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setRole('ROLE_USER');
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $status = 'Te has registrado correctamente';
                $this->session->getFlashBag()->add('succes', $status);

            }else{
                $status = 'El usuario ya existe';
                $this->session->getFlashBag()->add('status', $status);

            }


        }else{
            $status = 'No te has registrado correctamente';
        }
        return $this->render('AppBundle:User:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
