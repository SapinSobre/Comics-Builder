<?php

//src/UserBundle/Controller/HomeController.php

namespace UserBundle\Controller;


use UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Entity\Picture;

class HomeController extends Controller{
    
    public function addUserAction(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            
            $user->getImageUser()->upload();

            $username= $user->getUsername();
            $imageUser = $user->getImageUser();

            $picture = new Picture();
            $picture->setUrl($imageUser->getUrl());
            $picture->setAlt($imageUser->getAlt());
            $picture->setUser($user);
            $picture->setTitle('Image de profil');
            
            //$em->persist($picture);
            $user->addPicture($picture);
            
            $em->persist($user);
            
            $em->flush();
            $session = $this->get('session');
            $session->set('username', $username);
            
            return $this->redirectToRoute('user_merci', array('users'=>$users, 'username'=>$username, 'users'=>$users));
        }  
        
        return $this->render('UserBundle:Home:index.html.twig', array(
            'form'=>$form->CreateView(),
            'users'=>$users
        ));    
    }
    
    public function merciAction($username){
       
        $em =$this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();                    
        $user = $em->getRepository('UserBundle:User')->findOneByUsername($username);
        return $this->render('UserBundle:Home:merci.html.twig', array('users'=>$users, 'user'=>$user));
    }
    

    
    
        /*public function testAction()
  {
    $user = new User();
        
   
    $user->setLastName('Nathalie');           // Champ « lastName » incorrect : moins de 10 caractères
    //$user->setLogin('blabla');    // Champ « Login » incorrect : on ne le définit pas
    $user->setName('Daoût');
    $user->setLogin('Sapin');
    $user->setPasswd('Sapinou74');
    $user->setBirth('1974-11-27 14:21:12');// Champ « birth » correct
    $user->setMail('sapin@mail.com');
    $user->setImageUser(new ImageUser());
    
    // On récupère le service validator
    $validator = $this->get('validator');
        
    // On déclenche la validation sur notre object
    $listErrors = $validator->validate($user);

    // Si $listErrors n'est pas vide, on affiche les erreurs
    if(count($listErrors) > 0) {
      // $listErrors est un objet, sa méthode __toString permet de lister joliement les erreurs
      return new Response((string) $listErrors);
    } else {
      return new Response("L'annonce est valide !");
    }
  }*/
    
}