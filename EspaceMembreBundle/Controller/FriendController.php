<?php

namespace EspaceMembreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

class FriendController extends Controller
{
    public function addFriendAction($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $user1 = $this->getUser();
        $user2 = $em->getRepository('UserBundle:User')->findOneById($userId);
        $user1->addFriend($user2);
        $user2->addFriend($user1);
        $em->flush();
        return $this->redirectToRoute('espace_membre_friend', array('users'=>$users));
    }
    public function friendAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        return $this->render('EspaceMembreBundle:Friend:friend.html.twig', array('users'=>$users));
    }
}
