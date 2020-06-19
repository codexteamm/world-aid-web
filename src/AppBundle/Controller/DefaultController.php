<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Contact;
use AssociationBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{

    public function loginMobileAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);


        $user = $user_manager->findUserByUsername($username);
        if(!$user)
            return $response;


        $encoder = $factory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
        if($bool=="true")
        {
            $role= $user->getRoles();

            $data=array('type'=>'Login succeed',
                'id'=>$user->getId(),

                'username'=>$user->getUsername(),

                'email'=>$user->getEmail(),

                'password'=>$user-> getPassword(),

                'nom'=>$user->getNom(),

                'prenom'=>$user->getPrenom(),

                'categorie'=>$user->getCategorie(),

                'description'=>$user->getDescriptioncassocial(),

                'adresse'=>$user->getAddresse(),

                'pays'=>$user->getPays(),

                'rib'=>$user->getRib(),

                'numero'=>$user->getNumero(),

                'logo'=>$user->getLogo(),

                'role'=>$user->getRoles(),
            );
            $response = new JsonResponse($data, 200);
            return $response;

        }
        else
        {
            return $response;

        }
        // return array('name' => $bool);
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        //  $user = $this->container->get('security.token_storage')->getToken()->getUser();


        $contact = new Contact();

        //prepare the form with the function: createForm()
        $form = $this->createForm(ContactType::class, $contact);


        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //var_dump($form);
        //if this form is valid
        if ($form->isSubmitted() && $form->isValid()) {
            //$campement->setIdassociation($user);
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();
            $message = (new \Swift_Message($contact->getSubject()))
                ->setFrom('worldaid2020@gmail.com')
                ->setTo("worldaid2020@gmail.com")
                ->setBody($contact->getMessage());
            $this->get('mailer')->send($message);
            //persist the object $club in the ORM

            $em->persist($contact);
            //update the data base with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('contact');
        }

        return $this->render('default/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function  addUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $talent = new User();
        $talent->setUsername($request->get('username'));
        $talent->setEmail($request->get('email'));
        $talent->setPlainPassword($request->get('password'));
        $talent->setRib($request->get('rib'));
        $talent->setAddresse($request->get('adresse'));
        $talent->setCategorie($request->get('categorie'));
        $talent->setLogo($request->get('logo'));
        $talent->setNumero($request->get('numero'));
        $talent->setSuperAdmin(false);
        $talent->isEnabled(true);
        $talent->setRoles(array('ROLE_ASSOCIATION'));
        $talent->setEnabled(true);

        $em->persist($talent);
        $em->flush();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('worldaid2020@gmail.com')
            ->setTo($talent->getEmail())
            ->setBody("bonjour");
        $this->get('mailer')->send($message);


        $serialize = new serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize($talent);
        return new  JsonResponse($formatted);
    }
    public function addBenAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $talent = new User();
        $talent->setUsername($request->get('username'));
        $talent->setEmail($request->get('email'));
        $talent->setPlainPassword($request->get('password'));
        $talent->setNom($request->get('nom'));
        $talent->setPrenom($request->get('prenom'));
        $talent->setPays($request->get('pays'));

        $talent->setLogo($request->get('logo'));
        $talent->setSuperAdmin(false);
        $talent->isEnabled(true);
        $talent->setRoles(array('ROLE_BENEVOLE'));
        $talent->setEnabled(true);
        $em->persist($talent);
        $em->flush();
        $serialize = new serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize($talent);
        return new JsonResponse($formatted);
    }
    public function addNecAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $talent = new User();
        $talent->setUsername($request->get('username'));
        $talent->setEmail($request->get('email'));
        $talent->setPlainPassword($request->get('password'));
        $talent->setNom($request->get('nom'));
        $talent->setPrenom($request->get('prenom'));
        $talent->setPays($request->get('pays'));
        $talent->setDescriptioncassocial($request->get('description'));
        $talent->setLogo($request->get('logo'));
        $talent->setRoles(array('ROLE_NECESSITEUX'));
        $talent->setEnabled(true);
        $talent->setSuperAdmin(false);
        $talent->isEnabled(true);
        $em->persist($talent);
        $em->flush();
        $serialize = new serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize($talent);
        return new JsonResponse($formatted);




    }
    public function showuserAction(){
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);


    }


    public function deleteUserAction($id){

        $em = $this->getDoctrine()->getManager();
        $u =$em->getRepository('AppBundle:User')->find($id);
        $em->remove($u);
        $em->flush();
        return new JsonResponse('succes');

    }
    public function updateUserAction(Request$request){
        $em = $this->getDoctrine()->getManager();
        $util = $em->getRepository('AppBundle:User')->find($request->get('id'));

        $util->setUsername($request->get('username'));
        $util->setUsernameCanonical($request->get('username'));
        $util->setEmail($request->get('email'));
        $util->setEmailCanonical($request->get('email'));
        $util->setPlainPassword($request->get('password'));

        $util->setPays($request->get('pays'));

        $util->setLogo($request->get('logo'));
        $util->setRib($request->get('rib'));
        $util->setAddresse($request->get('adresse'));
        $util->setCategorie($request->get('categorie'));
        $util->setNumero($request->get('numero'));

        $em->persist($util);
        $em->flush();
        //$serializer=new Serializer([new ObjectNormalizer()]);
        //$formatted=$serializer->normalize($util);
        return new JsonResponse("success");
    }

    public function updateBenAction(Request$request){
        $em = $this->getDoctrine()->getManager();
        $util = $em->getRepository('AppBundle:User')->find($request->get('id'));

        $util->setUsername($request->get('username'));
        $util->setUsernameCanonical($request->get('username'));
        $util->setEmail($request->get('email'));
        $util->setEmailCanonical($request->get('email'));
        $util->setPlainPassword($request->get('password'));
        $util->setNom($request->get('nom'));
        $util->setPrenom($request->get('prenom'));
        $util->setPays($request->get('pays'));
        $util->setLogo($request->get('logo'));


        $em->persist($util);
        $em->flush();
        //$serializer=new Serializer([new ObjectNormalizer()]);
        //$formatted=$serializer->normalize($util);
        return new JsonResponse("success");
    }
    public function updateNeceAction(Request$request){
        $em = $this->getDoctrine()->getManager();
        $util = $em->getRepository('AppBundle:User')->find($request->get('id'));

        $util->setUsername($request->get('username'));
        $util->setUsernameCanonical($request->get('username'));
        $util->setEmail($request->get('email'));
        $util->setEmailCanonical($request->get('email'));
        $util->setPlainPassword($request->get('password'));
        $util->setNom($request->get('nom'));
        $util->setPrenom($request->get('prenom'));
        $util->setPays($request->get('pays'));
        $util->setLogo($request->get('logo'));
        $util->setDescriptioncassocial($request->get('description'));


        $em->persist($util);
        $em->flush();
        //$serializer=new Serializer([new ObjectNormalizer()]);
        //$formatted=$serializer->normalize($util);
        return new JsonResponse("success");
    }

}
