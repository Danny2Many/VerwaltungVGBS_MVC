<?php

namespace AppBundle\Form\Type\Trainer;

use AppBundle\Form\Type\PersonalDataType;
use AppBundle\Form\Type\Trainer\TrainerFocusType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;





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
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'))
        ->add('section', EntityType::class,  array(
            'class' => 'AppBundle:Section',
            'choice_label' => 'sectionname',
            'multiple' => true,
            'expanded' => true,
            'label' => 'Abteilung/en:'))
        ->add('focus', CollectionType::class, array('entry_type' => TrainerFocusType::class, 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true,))
        ->get('phonenumber')->setData('AppBundle\Entity\Trainer\TrainerPhoneNumber')
                
        ;        
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Trainer\Trainer',));
    }
}

