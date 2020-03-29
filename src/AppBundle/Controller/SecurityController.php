<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Security:necessiteux_home.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/home")
     */
    public function redirectAction()
    {
        $authChecker= $this->container->get('security.authorization_checker');
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('@Admin/admin_home.html.twig');
        }
        else if ($authChecker->isGranted('ROLE_NECESSITEUX')){
            return $this->render('@Necessiteux/necessiteux_home.html.twig');
        }
        else if ($authChecker->isGranted('ROLE_BENEVOLE')){
            return $this->render('@Benevole/benevole_home.html.twig');
        }
        else if ($authChecker->isGranted('ROLE_ASSOCIATION')){
            return $this->render('@Association/association_home.html.twig');
        }
        else{
            return $this->render('@FOSUser/Security/login.html.twig');
        }

    }

}
