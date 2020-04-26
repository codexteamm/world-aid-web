<?php

namespace AppBundle\Controller;

use AssociationBundle\Entity\Contact;
use AssociationBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        //  $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $contact = new Contact();

        //prepare the form with the function: createForm()
        $form = $this->createForm(ContactType::class, $contact);


        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            //$campement->setIdassociation($user);
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();

            //persist the object $club in the ORM
            $em->persist($contact);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('contact');
        }

        return $this->render('default/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
