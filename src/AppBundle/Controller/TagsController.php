<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tags;
use AppBundle\Form\TagsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;



class TagsController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }
    /**
     * @Route("/tags/index", name="index_tag")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo=$em->getRepository("AppBundle:Tags");
        $tags = $tagRepo->findAll();
        return $this->render('AppBundle:Tag:index.html.twig', array(
            'tags' => $tags
        ));
    }
    /**
     * @Route("/tags/add", name="add_tag")
     */
    public function addAction(Request $request)
    {
        $tag = new Tags();
        $form = $this->createForm(TagsType::class,$tag);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
                if ($form->isValid()){
                    $validator = $this->get('validator');
                    $errors = $validator->validate($tag);
                    if (count($errors) > 0) {
                        $status = (string) $errors;
                    }else{

                        $tag =new Tags();
                        $tag->setName($form->get("name")->getData());
                        $tag->setDescription($form->get("description")->getData());
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($tag);
                        $em->flush();
                        if ($em->flush() == null){
                            $status= 'La etiqueta se ha creado correctamente';

                        }else{
                            $status= 'La etiqueta no se ha creado, fallo de envío de formulario';
                        }
                    }
                }else{
                    $status= 'La etiqueta no se ha creado, fallo de envío de formulario';
                }
            $this->session->getFlashBag()->add('status', $status);
            return $this->redirectToRoute('index_tag');

        }


        return $this->render('AppBundle:Tag:tag.html.twig', array(
            'form' => $form->createView()
        ));

    }
    /**
     * @Route("/tags/delete/{id}", name="delete_tag")
     */
    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $tagRepo=$em->getRepository("AppBundle:Tags");
            $tag = $tagRepo->find($id);
            $em->remove($tag);
            $em->flush();
            return $this->redirectToRoute('index_tag');
    }
}
