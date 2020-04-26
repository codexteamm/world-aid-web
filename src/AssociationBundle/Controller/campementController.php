<?php

namespace AssociationBundle\Controller;

use AppBundle\Entity\Campement;
use AssociationBundle\Entity\Contact;
use AssociationBundle\Form\CampementType;
use AssociationBundle\Form\ContactType;


use AssociationBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class campementController extends Controller
{
    public function newMobileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Campement = new Campement();
        $Campement->setNom($request->get('nom'));
        $Campement->setDescription($request->get('description'));
        $Campement->setLatitude($request->get('latitude'));
        $Campement->setLongitude($request->get('longitude'));
        $Campement->setPaye($request->get('pays'));

        $em->persist($Campement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Campement);
        return new JsonResponse($formatted);
    }
    public function allmobileAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Campement::class);

        $listecamp = $repository->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idassociation'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Campement::class, 'json');

        /*********************************/
        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($listecamp);
        return new JsonResponse($formatted);
    }

    public function findMobileAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Campement')
            ->find($id);
        /****************************/
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idassociation'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(Campement::class, 'json');

        /*********************************/
        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities = $em->createQuery( 'SELECT e
                FROM AppBundle:Campement e
                WHERE e.nom LIKE :str'
        )
            ->setParameter('str', '%'.$requestString.'%')
            ->getResult();

        if(!$entities) {
            $result['entities']['error'] = "not found";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = [$entity->getNom(),$entity->getDescription(),$entity->getPaye(),$entity->getLongitude(),$entity->getLatitude(),$entity->getId() ];
        }

        return $realEntities;
    }
    public function showAllAction(Request $request)
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository(Campement::class);

        $listecamp = $repository->findAll();
        $camps  = $this->get('knp_paginator')->paginate(
            $listecamp,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );

        return $this->render('@Association/campement/recherche.html.twig', array("listecamp" => $camps,"user"=>$user ));
    }
    public function contactAction(Request $request)
    {
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

        return $this->render('AssociationBundle:campement:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function deleteAction($id)
    {
        //first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $club= $em->getRepository(Campement::class)->find($id);
        //var_dump($club);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('recherche');
    }

    public function takeChargeAction($id)
    {


        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository(Campement::class);

            $listecamp = $repository->find($id);
            $user->addcampement($listecamp);

            $this->get('fos_user.user_manager')->updateUser($user, false);

            // make more modifications to the database

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('recherche');



    }
    public function nontakeChargeAction($id)
    {


        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository(Campement::class);

        $camp = $repository->find($id);

        $user->removecampement($camp);
        $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('recherche');



    }

    public function showMineAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $listecamp=$user->getIdcampement();
        $camps  = $this->get('knp_paginator')->paginate(
            $listecamp,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );


        return ($this->render('@Association/campement/show_mine.html.twig',
            array("listecamp" => $camps)));


    }




    public function editAction(Request $request, $id)
    {//first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $campement = $em->getRepository(Campement::class)->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        //third step:
        // check is the from is sent
        if ($request->isMethod('POST')) {
            //update our object given the sent data in the request

            $campement ->setNom($request->get('nom'));
            $campement ->setDescription($request->get('description'));




            //fresh the data base
            $em->flush();
            //Redirect to the read
            return $this->redirectToRoute('recherche');
        }
        //second step:
        // send the view to the user
        return $this->render('@Association/campement/edit.html.twig', array(
            'campement' => $campement));
    }
        //second step:        $em=$this->getDoctrine()->getManager();
        //        $campement = $em->getRepository(Campement::class)->find($id);
        //        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //
        //        $id = $user->getId();
        //        //third step:
        //        // check is the from is sent
        //        if ($request->isMethod('POST')) {
        //            //update our object given the sent data in the request
        //
        //            $campement ->setNom($request->get('nom'));
        //            $campement ->setDescription($request->get('description'));
        //            /*$campement ->setPaye($request->get('paye'));
        //            $campement ->setLongitude($request->get('longitude'));
        //            $campement ->setLatitude($request->get('latitude'));*/
        //
        //
        //            //fresh the data base
        //            $em->flush();
        //            //Redirect to the read
        //            return $this->redirectToRoute('show_all');
        // send the view to the user


    public function createAction(Request $request)
    {
      //  $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $campement = new Campement();

        //prepare the form with the function: createForm()
        $form = $this->createForm(CampementType::class, $campement);


        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            //$campement->setIdassociation($user);
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();

            //persist the object $club in the ORM
            $em->persist($campement);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('recherche');
        }

        return $this->render('AssociationBundle:campement:create.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $recherche = new \AssociationBundle\Entity\RechercheType();
        $form = $this->createForm(RechercheType::class, $recherche);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $formations = $em->createQuery( 'SELECT e
                FROM AppBundle:Campement e
                WHERE e.nom LIKE :str AND e.paye LIKE :st'
            )
                ->setParameter('str', '%'.$recherche->getNom().'%')
                ->setParameter('st', '%'.$recherche->getPaye().'%')
                ->getResult();
            /*$formations = $this->getDoctrine()->getRepository(Campement::class)
                ->findBy(array('nom' => $campement->getNom()));*/}

        else{
            $formations = $this->getDoctrine()->getRepository(Campement::class)
                ->findAll();
        }
        $camps  = $this->get('knp_paginator')->paginate(
            $formations,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('@Association/campement/recherche.html.twig', array("form" => $form->createView(),"listecamp" => $camps ,"user"=>$user ));
       // return $this->render("@Club/Formation/recherche.html.twig", array("form" => $form->createView(), 'formations'=>$formations));

    }

}
