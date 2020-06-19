<?php

namespace BenevoleBundle\Controller;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\User;
use BenevoleBundle\Entity\Eventfeedback;
use BenevoleBundle\Form\EventfeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


class FeedbackController extends Controller
{
    public function addfeedbackAction(Request $request, $id)

    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $eventfeedback = new Eventfeedback();



        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);



        $repositoryeventfb = $this->getDoctrine()->getManager()->getRepository(Eventfeedback::class)->findBy(['idbenevole' => $user,
            'idevenement' => $id]);



        $listevent = $repository->find($id);

        $eventfeedback->setIdevenement($listevent);
        $eventfeedback->setIdbenevole($user);

         $form = $this->createForm(EventfeedbackType::class, $eventfeedback);
         $form->add('Add', SubmitType::class, ['label' => 'Add feedback']);

         $form = $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($eventfeedback);
             $em->flush();
             return $this->redirectToRoute('showfeedback', array('id' => $id));
         }


         return $this->render('BenevoleBundle:Feedback:addfeedbackevent.html.twig', array(
             'form' => $form->createView()
         ));

    }

    public function editfeedbackAction(Request $request, $id)
    {
        //get the club with $id with manager permission
        $em = $this->getDoctrine()->getManager();
        $eventfeedback = $em->getRepository(Eventfeedback::class)->find($id);


        if ($request->isMethod('POST')) {

            $eventfeedback->setSujet($request->get('sujet'));
            $eventfeedback->setMessage($request->get('message'));
            $em->flush();
            return $this->redirectToRoute('allevents');
        }

        return $this->render('BenevoleBundle:Feedback:editfeedbackevent.html.twig', array(
            'eventfeedback' => $eventfeedback));
    }

    public function showfeedbackAction($id) {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $eventfeedback =$this->getDoctrine()->getManager()->getRepository(Eventfeedback::class)->findBy(['idbenevole' => $user,
            'idevenement' => $id]);


        $listevents = $this->getDoctrine()
            ->getRepository(evenement::class)->find($id);

      return ($this->render('BenevoleBundle:Feedback:showfeedbackevent.html.twig', array("eventfeedback" => $eventfeedback ,"listevents" => $listevents)));

    }


    public function deletefeedbackAction(Request $request , $id)
    {
        //first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $eventfeedback= $em->getRepository(eventfeedback::class)->find($id);
        //var_dump($club);
        $em->remove($eventfeedback);
        $em->flush();
        return $this->redirectToRoute('allevents');
    }



    public function addfeedbackJSONAction (Request $request)
    {


        $eventfeedback = new Eventfeedback();
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);
        $event = $repository->find($request->get('idevenement'));

        $repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $repositoryuser->find($request->get('idbenevole'));


        $eventfeedback->setIdevenement($event);
        $eventfeedback->setIdbenevole($user);
        $eventfeedback->setSujet($request->get('sujet'));
        $eventfeedback->setMessage($request->get('message'));


        $em = $this->getDoctrine()->getManager();
        $em->persist($eventfeedback);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idevenement','idbenevole'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Eventfeedback::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($eventfeedback);
        return new JsonResponse($formatted);


    }
    public function editfeedbackJSONAction(Request $request)
    {
        //get the club with $id with manager permission
        $em = $this->getDoctrine()->getManager();
        $eventfeedback = $em->getRepository(Eventfeedback::class)->find($request->get('id'));




        $eventfeedback->setSujet($request->get('sujet'));
        $eventfeedback->setMessage($request->get('message'));
        $em->flush();



        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idevenement','idbenevole'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Eventfeedback::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($eventfeedback);
        return new JsonResponse($formatted);
    }







    public function showfeedbackJSONAction(Request $request) {

        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);
        $event = $repository->find($request->get('idevenement'));

        $repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        $user = $repositoryuser->find($request->get('idbenevole'));

        $eventfeedback =$this->getDoctrine()->getManager()->getRepository(Eventfeedback::class)->findBy(['idbenevole' => $user,
            'idevenement' => $event]);

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idevenement','idbenevole'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Eventfeedback::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($eventfeedback);
        return new JsonResponse($formatted);
    }







    public function deletefeedbackJSONAction(Request $request)
    {
        //first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $eventfeedback= $em->getRepository(eventfeedback::class)->find($request->get('id'));
        //var_dump($club);
        $em->remove($eventfeedback);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idevenement','idbenevole'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Eventfeedback::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($eventfeedback);
        return new JsonResponse($formatted);
    }


}


