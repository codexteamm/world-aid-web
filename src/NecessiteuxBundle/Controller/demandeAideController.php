<?php

namespace NecessiteuxBundle\Controller;

use NecessiteuxBundle\Entity\DemandeAide;
use NecessiteuxBundle\Form\DemandeAideType;
use NecessiteuxBundle\Entity\Notification;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
}
