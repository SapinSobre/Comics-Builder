<?php

//src/UserBundle/Validator/AntifloodValidator.php

namespace UserBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

class AntifloodValidator extends ConstraintValidator{
    
    /*private $requestStack;
    private $em;
    
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }*/
    
    public function validate($value, Constraint $constraint){
        
         /* Pour récupérer l'objet Request tel qu'on le connait, il faut utiliser getCurrentRequest du service request_stack
    $request = $this->requestStack->getCurrentRequest();

    // On récupère l'IP de celui qui poste
    $ip = $request->getClientIp();

    // On vérifie si cette IP a déjà posté une candidature il y a moins de 15 secondes
    $isFlood = $this->em
      ->getRepository('OCPlatformBundle:Application')
      ->isFlood($ip, 15) // Bien entendu, il faudrait écrire cette méthode isFlood, c'est pour l'exemple
    ;

    if ($isFlood) {
      // C'est cette ligne qui déclenche l'erreur pour le formulaire, avec en argument le message
      $this->context->addViolation($constraint->message);
    }*/
        
        if(strlen($value)<3){
            $this->context->addViolation($constraint->message);
        }
    }
}

