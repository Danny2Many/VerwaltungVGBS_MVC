<?php
namespace AppBundle\Form\Type\Location;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\RoomType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;


class BaseLocationType extends AbstractType {
   public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('locname', SanitizedTextType::class, array ('label' => 'Räumlichkeitsbezeichnung:'))
        ->add('streetaddress', SanitizedTextType::class, array ('label' => 'Adresse:'))
        ->add('postcode',IntegerType::class, array('label'=>'PLZ: '))
        
        ->add('room', CollectionType::class, array('entry_type' => RoomType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\Room'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
                
        //buttons to save, cancel and reset the current form        
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));
         
        
    } 
}
