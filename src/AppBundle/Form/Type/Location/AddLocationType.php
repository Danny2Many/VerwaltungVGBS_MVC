<?php

namespace AppBundle\Form\Type\Location;

use AppBundle\Form\Type\Location\BaseLocationType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLocationType extends BaseLocationType 
{
   public function configureOptions(OptionsResolver $resolver)
    {
     $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Location'));
    } 
}
