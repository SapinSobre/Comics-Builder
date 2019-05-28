<?php

//src/ForumBundle/Controller/AnnonceController.php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Advert;
use UserBundle\Entity\User;
use ForumBundle\Entity\CommentAdvertText;
use EspaceMembreBundle\Entity\ImageAll;
use ForumBundle\Entity\Comment;
use ForumBundle\Form\AdvertType;
use ForumBundle\Form\CommentAdvertTextType;
use ForumBundle\Form\Concours;


class AdvertController extends Controller{
    
    public function addAdvertAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class,$advert);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $advert->getImageAll()->upload();
            $imageAll = $advert->getImageAll();
            $advert->setUrl($imageAll->getUrl());
            $advert->setAlt($imageAll->getAlt());
            $user = $this->getUser();
            $advert->setUser($user);
            $em->persist($imageAll);
            $em->persist($advert);
            $em->flush();
            return $this->redirectToRoute('forum_view_advert');
            }
        return $this->render('ForumBundle:Advert:addAdvert.html.twig', array(
            'users'=>$users,
            'form'=>$form->createView()));
    }

    public function viewAdvertAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $adverts = $em->getRepository('ForumBundle:Advert')->findAll();
        return $this->render('ForumBundle:Advert:viewAdvert.html.twig', array('users'=>$users, 'adverts'=>$adverts));
    }

    public function viewOneAdvertAction(Request $request, $advertId, $delete){
        $advertId = (int)$advertId;
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $advert = $em->getRepository('ForumBundle:Advert')->findOneById($advertId);
        $commentAdvertText = new CommentAdvertText();
        $form = $this->createForm(CommentAdvertTextType::class,$commentAdvertText);
        $user = $this->getUser();
        $commentAdvertTexts = $advert->getCommentAdvertTexts();
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $commentAdvertText->setUser($user);
            $advert->addCommentAdvertText($commentAdvertText);
            $commentAdvertText->setAdvert($advert);
            $em->persist($commentAdvertText);
            $commentAdvertTexts = $advert->getCommentAdvertTexts();
            $em->flush();
            return $this->redirectToRoute('forum_view_one_advert', array('users'=>$users, 'advert'=>$advert, 'advertId'=>$advertId, 'commentAdvertTexts'=>$commentAdvertTexts, 'delete'=>$delete, 'form'=>$form->createView()));
        }
        return $this->render('ForumBundle:Advert:viewOneAdvert.html.twig', array('users'=>$users, 'advert'=>$advert, 'commentAdvertTexts'=>$commentAdvertTexts, 'delete' =>$delete, 'form'=>$form->createView()));
    }

    public function deleteAdvertAction($advertId){
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $advert = $doctrine->getRepository("ForumBundle:Advert")->findOneById($advertId);
        var_dump($advert->getId(). " ". $advert->getUser()->getName());
        //$advert = null;
        $em->remove($advert);
        $em->flush();
        return $this->redirectToRoute("forum_view_advert");
    }

    public function editAdvertAction(Request $request, $advertId){
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $advert = $em->getRepository('ForumBundle:Advert')->findOneById($advertId);
        $form = $this->createForm(AdvertType::class,$advert);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $imageAll = $advert->getImageAll();
            $em->persist($imageAll);
            $em->persist($advert);
            $em->flush();
            return $this->redirectToRoute('forum_view_advert');
        }
        return $this->render('ForumBundle:Advert:editAdvert.html.twig', array('users'=>$users, 'form'=>$form->createView()));
    }


}
