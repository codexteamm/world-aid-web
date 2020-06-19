<?php


namespace AssociationBundle\Controller;


use AppBundle\Entity\DonMateriel;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\User;
#use AssociationBundle\Entity\Eventfeedback;
use AssociationBundle\Form\evenementType;
#use AssociationBundle\Form\EventfeedbackType;
use BenevoleBundle\BenevoleBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class evenementController extends Controller
{

    public function showMyMobileAction()
    {
        //$repositoryuser = $this->getDoctrine()->getManager()->getRepository(User::class);
        //$user = $repositoryuser->find($request->get('idAssociation'));

        // $listevents = $user->getIdevenement();
        //$normalizer = new ObjectNormalizer();
        //$normalizer->setIgnoredAttributes(array('idbenevole','dateDebutEvent', 'dateFinEvent'));
        //$encoder = new JsonEncoder();

        //$serializer = new Serializer(array($normalizer), array($encoder));
        //$serializer->serialize(evenement::class, 'json');

        //$serializer = new Serializer([$normalizer]);
        //$formatted = $serializer->normalize($listevents);
        //return new JsonResponse($formatted);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT c
        FROM AppBundle:Evenement c where c.idAssociation=1'
        );
        $Clubs = $query->getArrayResult(); //get the result in an array structure
        $response = new Response(json_encode($Clubs));// encoder le resultat (la valeur) en format json
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function showAllMobileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
        FROM AppBundle:Evenement e '
        );
        $events = $query->getArrayResult();
        $response = new Response(json_encode($events));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function newMobileAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $evenement = new Evenement();

        $evenement->setNomEvent($request->get('nomEvent'));
        //$evenement->setDateDebutEvent($request->get('dateDeb'));
        //$evenement->setDateFinEvent($request->get('dateFin'));
        $evenement->setDateDebutEvent(new \DateTime('now'));
        $evenement->setDateFinEvent(new \DateTime('now'));
        $evenement->setLongitude($request->get('longitude'));
        $evenement->setLatitude($request->get('latitude'));
        $evenement->setDescription($request->get('description'));
        $evenement->setCategorie($request->get('categorie'));
        $evenement->setCreerLe(new \DateTime('now'));
        //$evenement->setIdassociation($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->flush();

        /* $normalizer = new ObjectNormalizer();
         $normalizer->setIgnoredAttributes(array('creerLe'));
         $encoder = new JsonEncoder();

         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($evenement);
         return new JsonResponse($formatted);*/
        //$events = $query->getArrayResult();
        $response = new Response(json_encode($em));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function findMobileAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Evenement')
            ->find($id);

        // $events = $tasks->getArrayResult();
        //  $response = new Response(json_encode($tasks));
        //$response->headers->set('Content-Type', 'application/json');
        //return $response;

        $serializer = new Serializer([new ObjectNormalizer()]);//serialiser l'objet
        $formatted = $serializer->normalize($tasks);//turn le result en array et vice versa
        return new JsonResponse($formatted);//encode la reponse normaliser
    }

    public function findMyMobileAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        $repository = $this->getDoctrine()
            ->getRepository(Evenement::class);

// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "p"
        $query = $repository->createQueryBuilder('c')
            ->where('c.idAssociation = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $events = $query->getArrayResult();
        $response = new Response(json_encode($events));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function deleteMobileAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $club= $em->getRepository('AppBundle:Evenement')->find($id);
        //var_dump($club);
        //die($club);
        $em->remove($club);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($club);
        return new JsonResponse($formatted);
    }

    public function  EditEventMobileAction(Request $request){

        $id = $request->query->get('idEvent');
        $em=$this->getDoctrine()->getManager();
        $Event=$em->getRepository('AppBundle:Evenement')->find($id);
        $nom = $request->query->get('nomEvent');
        $dateDebut = $request->query->get('dateDeb');
        $dateFin=$request->query->get('dateFin');
        $description = $request->query->get('description');
        $categorie=$request->query->get('categorie');

        $Event->setNomEvent($nom);
        //$Event->setDateDebutEvent($dateDebut);
        // $Event->setDateFinEvent($dateFin);
        $Event->setDescription($description);
        $Event->setCategorie($categorie);
        try {
            $em->persist($Event);
            $em->flush();
        }
        catch(\Exception $ex)
        {
            $data = [
                'title' => 'validation error',
                'message' => 'Some thing went Wrong',
                'errors' => $ex->getMessage()
            ];
            $response = new JsonResponse($data,400);
            return $response;
        }
        return $this->json(array('title'=>'successful','message'=> "Event Edited successfully"),200);
    }

    public function FeedBackMobileAction(Request $request,$id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('BenevoleBundle:Eventfeedback');

        $query = $repository->createQueryBuilder('c')
            ->where('c.idevenement = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $events = $query->getArrayResult();
        $response = new Response(json_encode($events));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

        /*   $listFeed = $query->getResult();
           $normalizer = new ObjectNormalizer();
           $normalizer->setIgnoredAttributes(array('idevenement','idbenevole'));
           $encoder = new JsonEncoder();

           $serializer = new Serializer(array($normalizer), array($encoder));
           $serializer->serialize(evenement::class, 'json');

           $serializer = new Serializer([new ObjectNormalizer()]);
           $formatted = $serializer->normalize($listFeed);
           return new JsonResponse($formatted);*/
        /*   $response = new Response(json_encode($listFeed));
           $response->headers->set('Content-Type', 'application/json');
           return $response;*/
    }


    public function newAction(Request $request)
    {
          $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $evenement = new Evenement();

        //prepare the form with the function: createForm()
        $form = $this->createForm(evenementType::class, $evenement);

        $form->add('ajouter',SubmitType::class , ['label' => 'Ajouter un evenement']);



        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setIdassociation($user);
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();

            //persist the object $club in the ORM
            $em->persist($evenement);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('show');
        }

        return $this->render('AssociationBundle:evenement:new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function showAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);

        $listeevent = $repository->findAll();
        return $this->render('@Association/evenement/show.html.twig', array("listeevent" => $listeevent));
    }

    public function editAction(Request $request, $id)
    {//first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        //third step:
        // check is the from is sent
        if ($request->isMethod('POST')) {
            //update our object given the sent data in the request

            $evenement ->setNomEvent($request->get('nom'));
            $evenement ->setDateDebutEvent($request->get('dateDebutEvent'|date('d-m-Y H:i:s')));
            $evenement ->setDateFinEvent($request->get('dateFinEvent'|date('d-m-Y H:i:s')));
            $evenement->setLongitude($request->get('longitude'));
            $evenement ->setLatitude($request->get('latitude'));
            $evenement ->setDescription($request->get('description'));
            $evenement ->setCategorie($request->get('categorie'));

            //fresh the data base
            $em->flush();
            //Redirect to the read
            return $this->redirectToRoute('show_My');
        }
        //second step:
        // send the view to the user
        return $this->render('@Association/evenement/editevent.html.twig', array(
            'evenement' => $evenement));
    }
    public function deleteAction($id)
    {
        //first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $club= $em->getRepository(Evenement::class)->find($id);
        //var_dump($club);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('show');
    }

    public function showMyEventAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        $repository = $this->getDoctrine()
            ->getRepository(Evenement::class);

// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "p"
        $query = $repository->createQueryBuilder('c')
            ->where('c.idAssociation = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $listeevent = $query->getResult();

        return ($this->render('@Association/evenement/show_my.html.twig',
            array("listeevent" => $listeevent)));
    }

    public function showBenevoleAction(Request $request,$id)
    {
        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($id);

        $listeben= $event -> getIdbenevole();

        return ($this->render('AssociationBundle:evenement:Show_benevole.html.twig',array ("listeben"=>$listeben)));
    }

    public function showDonAction(Request $request,$id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(DonMateriel::class);

// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "p"
        $query = $repository->createQueryBuilder('c')
            ->where('c.idEvenement = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $listedon = $query->getResult();
        dump($listedon);
        return ($this->render('AssociationBundle:evenement:show_don.html.twig',array ("listedon"=>$listedon)));
    }

    public function deleteDonAction($id)
    {
        //first step:
        //get the club with $id with manager permission
        $em=$this->getDoctrine()->getManager();
        $club= $em->getRepository(DonMateriel::class)->find($id);
        //var_dump($club);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('show');
    }

    public function showPdfAction()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $repository = $this->getDoctrine()->getManager()->getRepository(Evenement::class);
        $listeevent = $repository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Association/evenement/pdf.html.twig', array("listeevent" => $listeevent));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

    public function sendMailAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Your Volunteering has been Approved')
            ->setFrom(['worldaid2020@gmail.com' => 'WorldAid'])
            ->setTo(['mohamedali.benslimane@esprit.tn' => 'A name'])
            ->setBody('Thank you for volunteering in our event, we will contact you soon  ');

        $this->get('mailer')->send($message);
        return $this->redirectToRoute('show_My');

    }
//Affichage feed back
    public function FeedBackAction(Request $request,$id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('BenevoleBundle:Eventfeedback');

        $query = $repository->createQueryBuilder('c')
            ->where('c.idevenement = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $listFeed = $query->getResult();
        dump($listFeed);
        return ($this->render('AssociationBundle:evenement:feedback.html.twig',array ("listFeed"=>$listFeed)));
    }


}