<?php
//src/CoreBundle/Controller/HomeController.php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{
    
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $concours = $em->getRepository('ForumBundle:Concours')->findAll();
        return $this->render('CoreBundle:Home:index.html.twig', array('concours'=>$concours));

    }
   
}