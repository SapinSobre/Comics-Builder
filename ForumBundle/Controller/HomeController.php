<?php

//src/PapierNumerique/ForumBundle/Controller/HomeController

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class HomeController extends Controller{
    
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $concours = $em->getRepository('ForumBundle:Concours')->findAll();
        return $this->render('ForumBundle:Home:index.html.twig', array('users'=>$users, 'concours'=>$concours));
    }

}