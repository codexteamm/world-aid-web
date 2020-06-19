<?php

namespace NecessiteuxBundle\Controller;

use http\Env\Request;
use NecessiteuxBundle\Entity\DemandeAide;
use NecessiteuxBundle\Form\DemandeAideType;
use NecessiteuxBundle\Entity\Notification;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

use Dompdf\Dompdf;
use Dompdf\Options;


class demandeAideController extends Controller
{

    public function readAction()
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $listdemandes = $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();
        return ($this->render("@Necessiteux/DemandeAide/requests.html.twig", array("listedemandes" => $listdemandes,"idCassocial"=> $currentUser)));
    }

    public function readAssociationAction()
    {
        $listdemandes = $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();

        return ($this->render("@Association/demandes.html.twig", array("listedemandes" => $listdemandes)));
    }

    public function readnotifAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(DemandeAide::class)->find($id);
        var_dump($demande);
        die();
        return $this->render('@Association/readnotif.html.twig', array("listedemandes" => $demande));
    }

    public function confirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(DemandeAide::class)->find($id);
        $demande->setEtat('1');
        $em->flush();
        return $this->redirectToRoute('demandes');

    }

    public function confirmRequestMobileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(DemandeAide::class)->find($id);
        $demande->setEtat('1');
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);

    }

    public function createAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $demande_aide = new DemandeAide();
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $demande_aide->setIdCassocial($currentUser);
        $form = $this->createForm(DemandeAideType::class, $demande_aide);
        $form->add('create', SubmitType::class, ['label' => 'Ajouter']);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();
            //presist the object $club in the ORM
            $em->persist($demande_aide);
            //update the database with flush;
            $em->flush();

            //redirect the route after the add
            return $this->redirectToRoute('requests');
        }
        return $this->render('@Necessiteux/DemandeAide/create.html.twig', array('form' => $form->createView()));
    }

    public function updateAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        //create an entity manager object
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(DemandeAide::class)->find($id);
        if ($request->isMethod('POST')) {
            $demande->setTitre($request->get('titre'));
            $demande->setDescription($request->get('description'));
            //update the database with flush;
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('requests');
        }
        return $this->render('@Necessiteux/DemandeAide/update.html.twig', array('demande' => $demande));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository(DemandeAide::class)->find($id);
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute('requests');
    }

    public function generate_pdfAction()
    {
        // Configure Dompdf according to your needs
        $demandes = $this->getDoctrine()->getManager()->getRepository(DemandeAide::class)->findAll();


        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Necessiteux/DemandeAide/PDF.html.twig',[
            'title' => "Bon de commande" , 'demandes' => $demandes
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);

    }

    public function allRequestsMobileAction()
    {
        $requests = $this->getDoctrine()->getManager()
            ->getRepository('NecessiteuxBundle:DemandeAide')->findAll();
        /****************************/
        $normalizer = new ObjectNormalizer();
        //$normalizer->setIgnoredAttributes(array('idCassocial'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(DemandeAide::class, 'json');

        /*********************************/

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($requests);
        return new JsonResponse($formatted);
    }

    public function addRequestMobileAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $demande_aide = new DemandeAide();
        $demande_aide->setTitre($request->get('titre'));
        $demande_aide->setDescription($request->get('description'));
        //$demande_aide->setIdCassocial($user);

        $em->persist($demande_aide);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande_aide);
        return new JsonResponse($formatted);
    }

    public function findRequestMobileAction($id)
    {
        $requests = $this->getDoctrine()->getManager()
            ->getRepository('NecessiteuxBundle:DemandeAide')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($requests);
        return new JsonResponse($formatted);
    }

    public function updateRequestMobileAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        //get the request with $id with manager permission
        $em = $this->getDoctrine()->getManager();
        $demande_aide = $em->getRepository('NecessiteuxBundle:DemandeAide')->find($id);

        $demande_aide->setTitre($request->get('titre'));
        $demande_aide->setDescription($request->get('description'));
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('idCassocial'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $serializer->serialize(DemandeAide::class, 'json');

        $serializer = new Serializer([$normalizer]);
        $formatted = $serializer->normalize($demande_aide);
        return new JsonResponse($formatted);
    }

    public function deleteRequestMobileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $demande_aide = $em->getRepository(DemandeAide::class)->find($id);
        $em->remove($demande_aide);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande_aide);
        return new JsonResponse($formatted);
    }
}
