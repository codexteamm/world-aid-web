<?php

namespace BenevoleBundle\Controller;

use BenevoleBundle\Entity\Eventfeedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BenevoleBundle\Repository\EvenementRepository;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;



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
    public function allEventsJSONAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
        FROM AppBundle:Evenement e '
        );
        $events = $query->getArrayResult();
        $response = new Response(json_encode($events));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



    public function benevoleEventsJSONAction(Request $request)
    {
        $repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $repositoryuser->find($request->get('idbenevole'));

        $listevents = $user->getIdevenement();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idassociation','idbenevole'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(evenement::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($listevents);
        return new JsonResponse($formatted);




    }



    public function volunteerJSONAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);
        $event = $repository->find($request->get('idevenement'));
        $repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $repositoryuser->find($request->get('idbenevole'));
        $user->addevent($event);
        $this->get('fos_user.user_manager')->updateUser($user, false);
        // make more modifications to the database
        $this->getDoctrine()->getManager()->flush();
        $message = (new \Swift_Message('WorldAid Email'))
            ->setFrom('worldaid2020@gmail.com')
            ->setTo($event-> getIdAssociation()->getEmail())
            ->setBody("A volunteer which his name is " .$user->getUsername(). " has volunteeered  in " .$event->getNomEvent());

        $this->get('mailer')->send($message);

        return new JsonResponse(['result' => 'ok' ]);
    }




    public function unvolunteerJSONAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);
        $event = $repository->find($request->get('idevenement'));
        $repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $repositoryuser->find($request->get('idbenevole'));
        $user->removeevent($event);
        $this->get('fos_user.user_manager')->updateUser($user, false);
        // make more modifications to the database
        $this->getDoctrine()->getManager()->flush();
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('worldaid2020@gmail.com')
            ->setTo($event-> getIdAssociation()->getEmail())
            ->setBody("A volunteer which his name is " .$user->getUsername(). " has unvolunteeered in ".$event->getNomEvent());

        $this->get('mailer')->send($message);
        return new JsonResponse(['result' => 'ok' ]);
    }





    public function showeventJSONAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $event = $this->getDoctrine()
            ->getRepository(evenement::class)->find($request->get('idevent'));

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idassociation', 'idbenevole', 'dateDebutEvent', 'dateFinEvent'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(evenement::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);


    }


}