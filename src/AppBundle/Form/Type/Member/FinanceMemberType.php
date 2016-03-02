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
            
            ->add('MitgliedsbeitrMonat', MoneyType::class, array('label' => 'Mitgliedsbeitr./Monat:'))
            ->add('Aufnahmegebuehr', MoneyType::class, array('label' =>'Aufnahmegebühr:'))
            ->add('Aufnahmegebuehr_gez', MoneyType::class)
            
            ->add('Zahlungseingang', ChoiceType::class, array('choices'  => array(
        'nein' => 'nein',
        'ja' => 'ja',
        
    ),
    
    'choices_as_values' => true,
    'label' => 'Zahlungseingang:'
    
))
            
            
            ->add('Beitr_QuartMonat1', MoneyType::class)
            ->add('Beitr_QuartMonat1_gez', MoneyType::class)
            ->add('Beitr_QuartMonat2', MoneyType::class)
            ->add('Beitr_QuartMonat2_gez', MoneyType::class)
            ->add('Beitr_QuartMonat3', MoneyType::class)
            ->add('Beitr_QuartMonat3_gez', MoneyType::class)               
            ->add('Umlage', MoneyType::class)
            ->add('Spende', MoneyType::class)
            ->add('zusaetzlInfo', MoneyType::class)
    
            
                   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MitgliederFinanzen',
        ));
    }
}
