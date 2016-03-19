<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form\Type\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class FinanceMemberType extends AbstractType {
    
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personaldata', PersonalDataType::class, array(
        'data_class' => 'AppBundle\Entity\Member',
        
    ))
           ->add('section', EntityType::class,  array(
            'class' => 'AppBundle:Section',
            'choice_label' => 'token',
            'multiple' => true,
            'required' => false,
            'label' => 'Abteilungen/n:'
            
        ))
            
            
           ->add('state', ChoiceType::class, array(
    'choices'  => array(
        'aktiv' => 'aktiv',
        'inaktiv' => 'inaktiv',
        
    ),
   
    'choices_as_values' => true,
    'label' => 'Status:'
    
))
                
                ->add('sportsgroup', EntityType::class,  array(
            'class' => 'AppBundle:MemSportsgroup',
            'choice_label' => 'token',
            'multiple' => true,
            'required' => false,
            'label' => 'Sportgruppe/n:'
            
        ))
                ->add('admissioncharge', MoneyType::class)
                ->add('admissionchargepayed', MoneyType::class)
            
            ->add('monthlydues', CollectionType::class, array('entry_type' => MonthlyDuesType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\MemMonthlyDues')))
            ->add('yearinfo', CollectionType::class, array('entry_type' => YearInfoType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\MemYearInfoDues')))
            
    
            
                   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member',
        ));
    }
}
