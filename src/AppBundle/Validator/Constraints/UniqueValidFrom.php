<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueValidFrom extends Constraint{
    public $message = 'Ein Beitrag darf keine zwei Preise besitzen, die ab dem selben Monat des selben Jahres gültig sind.';
}
