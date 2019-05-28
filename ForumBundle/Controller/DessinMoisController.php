<?php
 //src/ForumBundle/Controller/DessinMoisController.php;

namespace ForumBundle\Controller;

use ForumBundle\Form\ConcoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Concours;

class DessinMoisController extends Controller{

    public function concoursAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $concours = $em->getRepository('ForumBundle:Concours')->findAll();
        return $this->render('ForumBundle:DessinMois:concours.html.twig', array('users'=>$users, 'concours'=>$concours));

    }

    public function addDessinConcoursAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $user = $this->getUser();
        $concours = new Concours();
        $form = $this->createForm(ConcoursType::class,$concours);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $concours->getImageAll()->upload();
            $imageAll = $concours->getImageAll();
            $concours->setUrl($imageAll->getUrl());
            $concours->setAlt($imageAll->getAlt());
            $concours->setUser($user);
            $em->persist($imageAll);
            $em->persist($concours);
            $em->flush();
            return $this->redirectToRoute('forum_concours');
        }


        return $this->render('ForumBundle:DessinMois:addDessinConcours.html.twig', array('users'=>$users, 'user'=>$user, 'form' => $form->createView()));
    }

}

