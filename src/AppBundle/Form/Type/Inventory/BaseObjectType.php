<?php

namespace AppBundle\Form\Type\Inventory;
use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\SanitizedTextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\ObjectOrderType;
use AppBundle\Form\Type\StocktakingType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;

class BaseObjectType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        
        $builder
        ->add('objectname', SanitizedTextType::class, array ('label' => 'Objektbezeichnung:'))
        ->add('description', SanitizedTextareaType::class, array ('label' => 'Objektbeschreibung:','required'=>false))
        
        //possibility to persist multiple orders and stocktakings to the database at once
        //(in form folder ObjectOrderType and StocktakingType)
        ->add('order', CollectionType::class, array('entry_type' => ObjectOrderType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\Inventory\ObjectOrder'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
        ->add('stocktaking', CollectionType::class, array('entry_type' => StocktakingType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\Inventory\Stocktaking'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))

        //buttons to save, cancel and reset the current form        
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));
         
        
    }
}
