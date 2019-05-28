<?php

//src/PapierNumerique/EspaceMembreBundle/Controller/HomeController.php

namespace EspaceMembreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Form\PictureType;
use UserBundle\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller{
    
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        return $this->render('EspaceMembreBundle:Home:index.html.twig', array('users'=>$users));
    }
    
    public function addPictureAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        
        $user = $this->getUser();
       
                
        $picture = new Picture(array("user"=>$user));
        $form = $this->createForm(PictureType::class,$picture);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
           
            
            $picture->getImageAll()->upload();
            $imageAll = $picture->getImageAll();
          
            $picture->setUrl($imageAll->getUrl());
            $picture->setAlt($imageAll->getAlt());
            //echo "ADD PICTURE<br>";
            $em->persist($picture);
            //echo "ici";
            $em->flush();
            
            return $this->redirectToRoute("espace_membre_homepage");
        }  
        
        return $this->render('EspaceMembreBundle:Home:addPicture.html.twig', array(
            
            'users'=>$users,
            'form'=>$form->createView(),
        ));    
    }


}
