<?php
namespace AppBundle\Form\Type\Nichtmitglieder;

use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\Type\PersonalDataType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\SanitizedTextareaType;
use AppBundle\Form\Type\RehabCertType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BaseNonMemberType extends PersonalDataType {
    
public function buildForm(FormBuilderInterface $builder, array $options){
    
    
    parent::buildForm($builder,$options);

        $builder
            
        ->add('trainingstartdate', DateType::class, array( 'label' => 'Trainingsbeginn:', 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'),'required' => false))
        ->add('trainingconfirmation', DateType::class, array( 'label' => 'Teilnahmebeginnbest.:', 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 'required' => false))       
        ->add('state', ChoiceType::class, array(
                'choices'  => array(
                    'aktiv' => 'aktiv',
                    'inaktiv' => 'inaktiv',
                ),
                'choices_as_values' => true,
                'label' => 'Status:'
        ))    
        ->add('settlementdate1', DateType::class, array( 'label' => 'Verrechnungsdat.1:', 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 'required' => false))        
        
        ->add('settlementdate2', DateType::class, array( 'label' => 'Verrechnungsdat.2:', 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 'required' => false))        
                
        ->add('rehabilitationcertificate', CollectionType::class, array('entry_type' => RehabCertType::class, 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true,))
                
        ->add('healthinsurance', SanitizedTextType::class, array('label' => 'Krankenkasse:', 'required' => false))
                
        ->add('additionalinfo', SanitizedTextareaType::class, array('label' => 'Zusatzinfo:', 'required' => false)) 

        ->add('workplaceposture', SanitizedTextareaType::class, array('label' => 'Arbeitsplatzhaltung:', 'required' => false))

        ->add('chronoccupationaldis', SanitizedTextareaType::class, array('label' => 'chron. Berufserkr:', 'required' => false))

        ->add('paincervicalspine', SanitizedTextType::class, array('label' => 'Schmerzen in HWS:', 'required' => false))

        ->add('painthoracicspine', SanitizedTextType::class, array('label' => 'Schmerzen in BWS:', 'required' => false))

        ->add('painlumbarspine', SanitizedTextType::class, array('label' => 'Schmerzen in LWS:', 'required' => false))

        ->add('upperlimbs', SanitizedTextType::class, array('label' => 'obere Extr.:', 'required' => false))

        ->add('lowerlimbs', SanitizedTextType::class, array('label' => 'untere Extr.:', 'required' => false))

        ->add('otherimpairments', SanitizedTextareaType::class, array('label' => 'sonst. Beeinträchtigungen:', 'required' => false))

        ->add('medication', SanitizedTextareaType::class, array('label' => 'Medikamente:', 'required' => false))

        ->add('additionalagilactivities', SanitizedTextareaType::class, array('label' => 'weit. bewegl. Aktivitäten:', 'required' => false))

        ->add('pulseatrest', NumberType::class, array( 'label' => 'Hf-Ruhe/Min:', 'scale' => 0, 'required' => false))
        ->add('sportsgroup', EntityType::class,  array(
            'class' => 'AppBundle:Nichtmitglieder\NonMemSportsgroup',
            'choice_label' => 'token',
            'multiple' => true,
            'required' => false,
            'label' => 'Sportgruppe/n:'
            
        )) 
        ->add('section', EntityType::class,  array(
            'class' => 'AppBundle:Section',
            'choice_label' => 'sectionname',            
            'label' => 'Abteilung:'
            
        )) 
          ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
          ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
          ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));
    
}    
}

