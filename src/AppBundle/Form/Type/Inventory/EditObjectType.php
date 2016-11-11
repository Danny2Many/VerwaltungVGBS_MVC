<?php

namespace AppBundle\Form\Type\Inventory;

use AppBundle\Form\Type\Inventory\BaseObjectType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditObjectType extends BaseObjectType
{public function buildForm(FormBuilderInterface $builder, array $options){
    parent::buildForm($builder, $options);
    //add the Inventory ID to the form and add a delete button
       $builder->add('invid',IntegerType::class, array('label' => 'Inventarnummer:', 'required' => false, 'disabled' => true) )
               ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));   
}
    
 public function configureOptions(OptionsResolver $resolver)
 {
  $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Inventory\Inventory'));
 }
}





