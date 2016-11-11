<?php

namespace AppBundle\Form\Type\Inventory;

use AppBundle\Form\Type\Inventory\BaseObjectType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddObjectType extends BaseObjectType
{
 public function configureOptions(OptionsResolver $resolver)
 {
  $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Inventory\Inventory'));
 }
}
