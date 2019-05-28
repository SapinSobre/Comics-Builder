<?php

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MinibookController extends Controller
{
    public function genereMinibookAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        return $this->render('GameBundle:Minibook:genereMinibook.html.twig', array('users' => $users));
    }
}
