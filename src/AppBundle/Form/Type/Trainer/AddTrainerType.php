<?php

namespace AppBundle\Form\Type\Trainer;

use AppBundle\Form\Type\Trainer\BaseTrainerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTrainerType extends BaseTrainerType
{
 public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Trainer\Trainer'));
    }
}

