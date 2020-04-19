<?php

namespace BenevoleBundle\Controller;

use AppBundle\Entity\DonMateriel;
use AppBundle\Entity\Evenement;
use BenevoleBundle\Entity\Eventfeedback;
use BenevoleBundle\Form\donMaterielType;
use AppBundle\Entity\User;
use BenevoleBundle\Form\PopUpdateType;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


class DonMaterielControllerController extends Controller
{


    public function addAction(Request $request,$id)
    {
        $ef = $this->getDoctrine()->getManager();
        $DonMateriel = new DonMateriel();
        $form = $this->createForm(donMaterielType::class, $DonMateriel);
        $form->handleRequest($request);
        $Evenement = $ef->getRepository(Evenement::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $DonMateriel->setIdBenevole($user);
            $DonMateriel->setIdEvenement($Evenement);
            $ef->persist($DonMateriel);
            $DonMateriel->setDateDon(new \DateTime('now'));
            $ef->flush();
            return $this->redirectToRoute("lire");
        }


        return $this->render("@Benevole/DonMateriel/create.html.twig", array("form" => $form->createView()));
    }

    public function readAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $id = $user->getId();
        $repository = $this->getDoctrine()
            ->getRepository(DonMateriel::class);

// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "d"
        $query = $repository->createQueryBuilder('d')
            ->where('d.idBenevole = :id')
            ->setParameter('id', $id)
            ->getQuery();


        $DonMateriel = $query->getResult();


        return ($this->render('@Benevole/DonMateriel/read.html.twig',
            array("donsMateriels" => $DonMateriel)));
    }

    public function readByIdEventAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $DonMateriel =$this->getDoctrine()->getManager()->getRepository(DonMateriel::class)->findBy(['idBenevole' => $user,
            'idEvenement' => $id]);


        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)->find($id);




        return ($this->render('@Benevole/DonMateriel/read.html.twig',
            array("donsMateriels" => $DonMateriel)));
    }






    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $donMateriel = $em->getRepository(DonMateriel::class)->find($id);
        //var_dump($club);
        $em->remove($donMateriel);
        $em->flush();
        return $this->redirectToRoute('lire');
    }


    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $DonMateriel = $em->getRepository(DonMateriel::class)->find($id);
        if ($request->isMethod('POST')) {
            //update our object given the sent data in the request
            $DonMateriel->setQuantite($request->get('quantite'));
            //fresh the data base
            $em->flush();
        }
        return $this->redirectToRoute('lire');
    }

    public function pdfAction(){
        $dons = $this->getDoctrine()->getManager()->getRepository(DonMateriel::class)->findAll();
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Benevole/DonMateriel/registration.html.twig', [
            'title' => "Liste de dons" , 'dons' => $dons
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }




    public function prepareAction()
    {
        return $this->render('@Benevole/DonMateriel/donateMoney.html.twig');
    }


    public function checkoutAction()
    {
        // Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_otytvtxxj8MMwbOLUwjwqRN500pY5rNa9Z');

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];
        try {
            $charge = \Stripe\Charge::create([
                'amount' => 10000,
                'currency' => 'eur',
                'description' => 'Donation',
                'source' => $token,
            ]);
            $this->addFlash("success", "Bravo ça marche !");
            return $this->redirectToRoute('prepare');
        } catch (\Stripe\Error\Card $e) {
            $this->addFlash("error", "Snif ça marche pas :(");
            return $this->redirectToRoute('prepare');
            // The card has been declined
        }


    }

}
