<?php

namespace NecessiteuxBundle\Controller;

use NecessiteuxBundle\Entity\Feedback;
use NecessiteuxBundle\Form\FeedbackType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FeedbackController extends Controller
{
    public function readAction()
    {
        $listfeedbacks=$this->getDoctrine()->getManager()->getRepository(Feedback::class)->findAll();
        return ($this->render("@Necessiteux/Feedback/feedbacks.html.twig",array("listefeedbacks"=>$listfeedbacks)));
    }

    public function createAction(\Symfony\Component\HttpFoundation\Request $request){
        $feedback=new Feedback();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $feedback->setIdCassocial($currentUser);
        $form=$this->createForm(FeedbackType::class,$feedback);
        $form->add('create2', SubmitType::class,['label'=>'Ajouter']);
        //extract the form answer from the received request
        $form=$form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if($form->isSubmitted() && $form->isValid()){
            //create an entity manager object
            $em=$this->getDoctrine()->getManager();
            //presist the object $club in the ORM
            $em->persist($feedback);
            //update the database with flush;
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('feedbacks');
        }
        return $this->render('@Necessiteux/Feedback/create.html.twig',array('form'=>$form->createView()));
    }

    public function updateAction(\Symfony\Component\HttpFoundation\Request $request,$id){
        //create an entity manager object
        $em=$this->getDoctrine()->getManager();
        $feedback=$em->getRepository(Feedback::class)->find($id);
        if($request->isMethod('POST')){
            $feedback->setTitre($request->get('titre'));
            $feedback->setMessage($request->get('message'));
            //update the database with flush;
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('feedbacks');
        }
        return $this->render('@Necessiteux/Feedback/update.html.twig',array('feedback'=>$feedback));
    }

    public function deleteAction($id){
        $em=$this->getDoctrine()->getManager();
        $feedback=$em->getRepository(Feedback::class)->find($id);
        $em->remove($feedback);
        $em->flush();
        return $this->redirectToRoute('feedbacks');
    }

}
