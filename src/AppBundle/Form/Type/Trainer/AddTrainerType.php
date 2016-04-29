<?php

namespace AppBundle\Form\Type\Trainer;

use AppBundle\Form\Type\PersonalDataType;
use AppBundle\Form\Type\PhoneNumberType;
use AppBundle\Form\Type\Trainer\TrainerFocusType;
use AppBundle\Form\Type\Trainer\TrainerLicenceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;





class AddTrainerType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder  
         
        ->add('personaldata', PersonalDataType::class, array(
        'data_class' => 'AppBundle\Entity\Trainer\Trainer',
        'pn_data_class' => 'AppBundle\Entity\Trainer\TrainerPhoneNumber')) 
                
        ->add('type', ChoiceType::class, array('choices'  => array(
        'Mitarbeiter' => 'Mitarbeiter', 'Übungsleiter' => 'Übungsleiter'),
        // *this line is important*
        'choices_as_values' => true,
        'label' => 'Art:',))
                
        ->add('state', ChoiceType::class, array('choices'  => array(
        'Inaktiv' => '0','Aktiv' => '1'),
        // *this line is important*
        'choices_as_values' => true,
        'label' => 'Status:',))
                
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'))
                
        ->add('nmemsportsgroup', EntityType::class,  array(
            'class' => 'AppBundle:Nichtmitglieder\NonMemSportsgroup',
            'choice_label' => 'Name',
            'multiple' => true,
            'expanded' => true,
            'label' => 'Sportgruppe/en:',
            'required' => false))
                
        ->add('theme', CollectionType::class, array('entry_type' => TrainerFocusType::class, 'entry_options'  => array('data_class'  => 'AppBundle\Entity\Trainer\TrainerFocus'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
        ->add('licence', CollectionType::class, array('entry_type' => TrainerLicenceType::class,'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))

               

                
        ;        
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Trainer\Trainer',));
    }
}

