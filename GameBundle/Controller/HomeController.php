<?php

//src/GameBundle/Controller/HomeController

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GameBundle\Form\PartieType;
use GameBundle\Entity\Partie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use GameBundle\Repository\Game;
use GameBundle\Entity\Answer;
use GameBundle\Form\AnswerType;
use UserBundle\Entity\User;

class HomeController extends Controller{
    
    /**
   * @Security("has_role('ROLE_USER')")
   */
    public function indexAction(){
/*
    // Création de l'entité Image
    $image = new Image();
    $image->setUrl('https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSqg8H2-s4zrCTcaQ0tHEkP7TgOdruBbKlx4NNAVhu5DOrc-oyA4A');
    $image->setAlt('mathilda');
    
    $image2 = new Image();
    $image2->setUrl('https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSrLY4oiyEOiSSfUaPgO2pRYrDA_AXp7xdnKs9JjMHd1X98mWfJ');
    $image2->setAlt('geants');
    // Création de l'entité Advert
    $game = new Game();
    $game->setName("Minibook");
    $game->setRule("Créez votre minibook seul ou à plusieurs.
                    Disposez vos dessins et textes dans les encarts prévus à cet effet.
                    Imprimez votre oeuvre sur une page A4. Pliez-la suivant quelques consignes simples.
                    Votre minibook est prêt!!!");
    $game->setNbPart("De 1 à 16 joueurs");
    $game->setCreatedAt(new \Datetime());
    $game->setImage($image);
    
    $game2 = new Game();
    $game2->setName("Storying-pong");
    $game2->setRule("Un premier joueur donne un premier dessin. Le suivant propose le sien. Celui-ci doit répondre au dessin du premier joueur. Le jeu continue jusqu'à ce que les joueurs décident que la partie est terminée.");
    $game2->setNbPart("De 2 à une infinité de joueurs");
    $game2->setCreatedAt(new \Datetime());
    $game2->setImage($image2);
    
    // On lie l'image à l'annonce
    
    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($game);
    $em->persist($game2);

    // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
    // on devrait persister à la main l'entité $image
    // $em->persist($image);

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();

    // … reste de la méthode
    
*/     $em = $this->getDoctrine()->getManager();
        $users=$em->getRepository('UserBundle:User')->findAll();
        $games = $em->getRepository('GameBundle:Game')->findAll();
        return $this->render('GameBundle:Home:index.html.twig', array('games'=>$games, 'users'=>$users));
    }
    
    public function nouveauMinibookAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $partie = new Partie();
        $form = $this->createForm(PartieType::class,$partie);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $game = $em->getRepository('GameBundle:Game')->findOneById(31);
            $user = $this->getUser();
            $partie->setGame($game);
            $partie->addUser($user);
            $em->persist($partie);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice','Nouvelle partie enregistrée');
            return $this->redirectToRoute('game_affiche_minibook');
        }  
        return $this->render('GameBundle:Home:nouveauMinibook.html.twig', array('users'=>$users, 'form'=>$form->createView()));
    }

    public function nouveauStoryingPongAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $user = $this->getUser();
        $partie = new Partie();
        $form = $this->createForm(PartieType::class,$partie);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $game = $em->getRepository('GameBundle:Game')->findOneById(32);
            $partie->setGame($game);
            $user->addPartie($partie);
            //$em->persist($user);
            $parties = $em->getRepository('GameBundle:Partie')->findAll();
            $em->flush();

            return $this->redirectToRoute('game_affiche_pong');
        }
        return $this->render('GameBundle:Home:nouveauStoryingPong.html.twig', array('users'=>$users, 'form'=>$form->createView()));
    }

    public function afficheMinibookAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $parties = $em->getRepository('GameBundle:Partie')->findAll();
        return $this->render('GameBundle:Home:afficheMinibook.html.twig', array('users'=>$users, 'parties'=>$parties));
    }

    public function affichePongAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $parties = $em->getRepository('GameBundle:Partie')->findAll();
        return $this->render('GameBundle:Home:affichePong.html.twig', array('users'=>$users, 'parties'=>$parties));
    }

    public function newAnswerAction(Request $request, $partieId){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $partie = $em->getRepository('GameBundle:Partie')->findOneById($partieId);
        $partieId = $partie->getId();
        $gameId = $partie->getGame()->getId();
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class,$answer);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $user = $this->getUser();
            $answer->getImageAll()->upload();
//            var_dump($user);
            $userId = $user->getId();
            $answer->setUserId($userId);
            $answer->setUrl($answer->getImageAll()->getUrl());
            $answer->setAlt($answer->getImageAll()->getAlt());
            $answer->setGameId($gameId);
            $partie->addAnswer($answer);
            $partie->addUser($user);
            $answer->setPartie($partie);
            $user->addPartie($partie);
            $parties = $em->getRepository('GameBundle:Partie')->findAll();

            $em->persist($user);
            $em->persist($answer);
            $em->flush();
            $players = $partie->getUsers();

            $request->getSession()->getFlashBag()->add('notice','Nouvelle partie enregistrée');
            if($answer->getGameId() == 31){
                return $this->render('GameBundle:Home:afficheMinibook.html.twig', array('users'=>$users, 'parties'=>$parties));
            }
            elseif($answer->getGameId() == 32) {
                return $this->render('GameBundle:Home:afficheAnswerStoryingPong.html.twig', array('users'=>$users, 'partie'=>$partie, 'parties'=>$parties, 'players'=>$players));
            }
        }
        return $this->render('GameBundle:Home:newAnswer.html.twig', array('users'=>$users, 'partieId'=>$partieId, 'form'=>$form->createView()));
    }

    public function afficheAnswerAction($partieId){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $partie = $em->getRepository('GameBundle:Partie')->findOneById($partieId);
        $answers = $em->getRepository('GameBundle:Answer')->findByPartie($partie);
        $players = $partie->getUsers();
        return $this->render('GameBundle:Home:afficheAnswer.html.twig', array('users'=>$users, 'answers'=>$answers, 'partie'=>$partie, 'players'=>$players));
    }

    public function afficheAnswerStoryingPongAction($partieId){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $partie = $em->getRepository('GameBundle:Partie')->findOneById($partieId);
        $answers = $em->getRepository('GameBundle:Answer')->findByPartie($partie);
        $players = $partie->getUsers();
        return $this->render('GameBundle:Home:afficheAnswerStoryingPong.html.twig', array('users'=>$users, 'answers'=>$answers, 'partie'=>$partie, 'players'=>$players));
    }
  
}


