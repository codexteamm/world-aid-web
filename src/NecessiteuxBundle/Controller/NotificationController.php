<?php

namespace NecessiteuxBundle\Controller;

use NecessiteuxBundle\Entity\Notification;
use NecessiteuxBundle\Form\NotificationType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class NotificationController extends Controller
{

    public function displayAction(){
        $notifications= $this->getDoctrine()->getManager()->getRepository('NecessiteuxBundle:Notification')->findAll();
        return $this->render('@Association/notifications.html.twig',array(
            'notifications'=>$notifications
        ));
    }

}
