<?php


namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ForumBundle\Entity\CommentAdvertText;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Form\CommentAdvertTextType;

class CommentController extends Controller
{
    public function addCommentAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();

        $commentAdvertText = new CommentAdvertText();
        $form = $this->createForm(CommentAdvertTextType::class,$commentAdvertText);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($commentAdvertText);

            $em->flush();

            return $this->redirectToRoute('forum_view_one_advert', array('users'=>$users));
        }


        return $this->redirectToRoute('ForumBundle:Advert:forum_view_one_advert.html.twig', array(
            'users'=>$users,
            'form'=>$form->createView()));
    }

    public function viewCommentsOneAdvertAction($advertId){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $advert = $em->getRepository('ForumBundle:Advert')->findOneById($advertId);
        return $this->render('ForumBundle:Comment:viewCommentsOneAdvert.html.twig', array('users'=>$users, 'advert'=>$advert));
    }

}