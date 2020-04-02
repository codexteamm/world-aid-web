<?php

namespace AssociationBundle\Controller;

use AppBundle\Entity\Campement;
use AssociationBundle\Form\CampementType;
use ClubBundle\Entity\club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class campementController extends Controller
{

    public function showAllAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Campement::class);

        $listecamp = $repository->findAll();
        return $this->render('@Association/campement/show_all.html.twig', array("listecamp" => $listecamp));
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
        return $this->redirectToRoute('show_all');
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
        return $this->redirectToRoute('show_all');

    }

    public function showMineAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        $repository = $this->getDoctrine()
            ->getRepository(Campement::class);

// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "p"
        $query = $repository->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery();


        $listecamp = $query->getResult();


        return ($this->render('@Association/campement/show_mine.html.twig',
            array("listecamp" => $listecamp)));


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
            $campement ->setPaye($request->get('paye'));
            $campement ->setLongitude($request->get('longitude'));
            $campement ->setLatitude($request->get('latitude'));


            //fresh the data base
            $em->flush();
            //Redirect to the read
            return $this->redirectToRoute('show_all');
        }
        //second step:
        // send the view to the user
        return $this->render('@Association/campement/edit.html.twig', array(
            'campement' => $campement));
    }


    public function createAction(Request $request)
    {
      //  $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $campement = new Campement();

        //prepare the form with the function: createForm()
        $form = $this->createForm(CampementType::class, $campement);
        $form->add('ajouter', SubmitType::class, ['label' => 'Ajouter club']);

        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            //$campement->setIdassociation($user);
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();

            //persist the object $club in the ORM
           // $em->persist($campement);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('show_all');
        }

        return $this->render('AssociationBundle:campement:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
