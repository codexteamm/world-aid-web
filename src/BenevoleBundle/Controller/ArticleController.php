<?php


namespace BenevoleBundle\Controller;


use AppBundle\Entity\DonMateriel;
use AppBundle\Entity\Evenement;
use BenevoleBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    public function addArticleAction(Request $request,$id)
    {
        $ef = $this->getDoctrine()->getManager();
        $Article = new Article();
        $Evenement = $ef->getRepository(Evenement::class)->find($id);
        if ($request->isMethod('POST')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $Article->setIdBenevole($user);
            $Article->setDate(new \DateTime('now'));
            $Article->setDescription($request->get('description'));
            $Article->setTitre($request->get('titre'));
            $Article->setMessage($request->get('message'));
            $Article->setIdEvenement($Evenement);
            $ef->persist($Article);
            $ef->flush();
            return $this->redirectToRoute('showArticle');
        }
        return $this->render("@Benevole/DonMateriel/addArticle.html.twig",array("event"=>$Evenement));
    }


    public function showArticleAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);
        $query = $repository->createQueryBuilder('a')
            ->where('a.idBenevole = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $Article = $query->getResult();

        return ($this->render('@Benevole/DonMateriel/article.html.twig',
            array("articles" => $Article)));
    }

    public function readArticleByIdEventAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $Article =$this->getDoctrine()->getManager()->getRepository(Article::class)->findBy(['idBenevole' => $user,
            'idEvenement' => $id]);


        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)->find($id);


        return ($this->render('@Benevole/DonMateriel/article.html.twig',
            array("articles" => $Article)));
    }

    public function showAllArticlesAction()
    {
        $listArticles = $this->getDoctrine()
            ->getRepository(Article::class)->findAll();
        return ($this->render('@Benevole/DonMateriel/allArticles.html.twig', array("listeArticles" => $listArticles)));
    }



    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $em->getRepository(Article::class)->find($id);
        //var_dump($club);
        $em->remove($Article);
        $em->flush();
        return $this->redirectToRoute('showArticle');
    }

    public function updateArticleAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Article = $em->getRepository(Article::class)->find($id);
        if ($request->isMethod('POST')) {
            //update our object given the sent data in the request
            $Article->setTitre($request->get('titre'));
            $Article->setDescription($request->get('description'));
            $Article->setMessage($request->get('message'));
            //fresh the data base
            $em->flush();
        }
        return $this->redirectToRoute('showArticle');
    }

}