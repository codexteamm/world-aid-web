<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomRegisrationController extends Controller
{
    /**
     * @Route("/registerAssociation")
     */
    public function registerAssociationAction(Request $request)
    {
        $user= new User();
        $form=$this->createForm(UserType::class,$user);
        $form=$form->handleRequest($request);
        if ($form->isSubmitted()){
            dump($user);
        }


        return $this->render('AppBundle:CustomRegisration:register_association.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/registerNeedy")
     */
    public function registerNeedyAction()
    {
        return $this->render('AppBundle:CustomRegisration:register_needy.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/registerDonor")
     */
    public function registerDonorAction()
    {
        return $this->render('AppBundle:CustomRegisration:register_donor.html.twig', array(
            // ...
        ));
    }

}
