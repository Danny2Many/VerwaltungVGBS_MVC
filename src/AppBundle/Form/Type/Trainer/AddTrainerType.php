<?php

namespace AppBundle\Form\Type\Trainer;

use AppBundle\Form\Type\PersonalDataType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;





class AddTrainerType extends PersonalDataType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder  
                
        ->add('type', ChoiceType::class, array('choices'  => array(
        'Mitarbeiter' => 'Mitarbeiter', 'Übungsleiter' => 'Übungsleiter'),
        // *this line is important*
        'choices_as_values' => true,
        'label' => 'Art:',))
                
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));
    }
}

