<?php

//src/UserBundle/Validator/Antiflood.php

namespace UserBundle\Validator;

use Symfony\Component\Validator\Constraint;



/**
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = "Vous vous êtes déjà inscrit(e) il y a 5 secondes.";
    
    public function validatedBy(){
        return 'user_antiflood';
    }
}
