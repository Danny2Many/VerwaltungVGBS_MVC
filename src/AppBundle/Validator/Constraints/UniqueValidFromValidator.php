<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValidFromValidator extends ConstraintValidator{
    
    public function validate($value, Constraint $constraint)
    {
            $checkArray=$value->toArray();

            while(count($checkArray)>=2){
                $checkCharge=array_pop($checkArray);
               
                foreach ($checkArray as $dc){
                    if($dc->getValidfrom()->format('m.Y')==$checkCharge->getValidfrom()->format('m.Y')){
                        $this->context->buildViolation($constraint->message)
                                ->addViolation();
                    }
                }
            }
    }
}
