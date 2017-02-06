<?php
namespace AppBundle\Form\Type\Location;
use AppBundle\Form\Type\Location\BaseLocationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EditLocationType extends BaseLocationType
{
 public function buildForm(FormBuilderInterface $builder, array $options){
    parent::buildForm($builder, $options);
       $builder->add('locid',IntegerType::class, array('label' => 'Standortnummer:', 'required' => false, 'disabled' => true) )
               ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));   
}
    
 public function configureOptions(OptionsResolver $resolver)
 {
  $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Location'));
 }    
}
