<?php

namespace NecessiteuxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NecessiteuxBundle:Default:index.html.twig');
    }
}
