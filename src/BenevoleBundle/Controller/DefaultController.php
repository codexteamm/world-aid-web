<?php

namespace BenevoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BenevoleBundle:Default:index.html.twig');
    }
}
