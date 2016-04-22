<?php

use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\Type\BSSACertType;

class BaseSportsgroupType {
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        
        ->add('name', SanitizedTextType::class, array ('label' => 'Sportgruppe:'))
        ->add('day', ChoiceType::class, array ('choices' => array ('Montag' =>'Montag', 'Dienstag' => 'Dienstag','Mittwoch' => 'Mittwoch', 'Donnerstag' => 'Donnerstag', 'Freitag' => 'Freitag'),
             'choices_as_values' => true,
            'label' => 'Wochentag:') )
        ->add('time', SanitizedTextType::class, array ('label' => 'Uhrzeit:'))
        ->add('info', SanitizedTextType::class, array ('label' => 'Info:'))
        ->add('token', SanitizedTextType::class, array ('label' => 'Gruppenbezeichnung:'))
        
         ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
          ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
          ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));        
     ;   
    }
}
