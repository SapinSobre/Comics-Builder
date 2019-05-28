<?php

//src/UserBundle/Controller/SecurityController.php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller{
    
    public function loginAction(Request $request){
        $users= $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findAll();
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $authenticationUtils = $this->get('security.authentication_utils');
            $username = $authenticationUtils->getLastUsername();
            return $this->redirectToRoute('espace_membre_homepage', array('username'=>$username));
        }
        // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');
    
    return $this->render('UserBundle:Security:login.html.twig', array(
      'users'=>$users,
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
    }
    
}