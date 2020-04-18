<?php

namespace AssociationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class



DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('GET OUT!');
        }    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('AssociationBundle:Default:index.html.twig');
    }
}
