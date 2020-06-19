<?php

namespace AppBundle\Controller;

use BenevoleBundle\Entity\Article;
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
            return $this->render('@EasyAdmin/default/layout.html.twig');
            //return $this->redirectToRoute('easy_admin_bundle');
            //return $this->render('@App/admin.html.twig');
           // return $this->render('@App/admin_home.html.twig');

        }
        else if ($authChecker->isGranted('ROLE_NECESSITEUX')){
            return $this->render('@Necessiteux/Default/index.html.twig');
        }
        else if ($authChecker->isGranted('ROLE_BENEVOLE')){
            $listArticles = $this->getDoctrine()
                ->getRepository(Article::class)->findAll();
            return ($this->render('@Benevole/DonMateriel/allArticles.html.twig', array("listeArticles" => $listArticles)));
        }
        else if ($authChecker->isGranted('ROLE_ASSOCIATION')){
            return $this->render('@Association/Default/index.html.twig');
        }
        else{
            return $this->render('@FOSUser/Security/login.html.twig');
        }

    }

}
