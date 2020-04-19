<?php

namespace BenevoleBundle\Controller;

use BenevoleBundle\Entity\Eventfeedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BenevoleBundle\Repository\EvenementRepository;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\User;

class BenevoleController extends Controller
{
    public function allEventsAction()
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $listevents = $this->getDoctrine()
            ->getRepository(evenement::class)->findAll();



        return ($this->render('BenevoleBundle:Benevole:allevents.html.twig', array("listevents" => $listevents , "user" => $user )));


        /*  return $this->render('BenevoleBundle:Benevole:allevents.html.twig', array(
              // ...
          ));*/
    }

    public function benevoleEventsAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $listevents = $user->getIdevenement();

        return ($this->render('BenevoleBundle:Benevole:Benevoleevents.html.twig', array("listevents" => $listevents)));


    }

    public function volunteerAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);

        $listevent = $repository->find($id);

        $user->addevent($listevent);

        $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();
        //mail
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('worldaid2020@gmail.com')
            ->setTo('hamza.lazhar1@esprit.tn')
            ->setBody("A volunteer has volunteeered ");

        $this->get('mailer')->send($message);

        return $this->redirectToRoute('allevents');


    }

    public function unvolunteerAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);

        $listevent = $repository->find($id);

        $user->removeevent($listevent);

        $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('allevents');


    }

    public function showeventAction($id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $event = $this->getDoctrine()
            ->getRepository(evenement::class)->find($id);


      return $this->render('BenevoleBundle:Benevole:showevent.html.twig', array(
              "event" => $event , "user" => $user
          ));}


}