<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Validator\Constraints;

/**
 * Description of Validator
 *
 * @author User-PC
 */
class Validator {
    
    public static function validate($form, ExecutionContextInterface $context, $payload)
    {
        if ($form->get('rehabunits')->getData() == 666) {
        $context->buildViolation('Diese Zahl ist zu teuflisch!')
            ->atPath('rehabunits')
            ->addViolation()
        ;
    }
    }
    
}
