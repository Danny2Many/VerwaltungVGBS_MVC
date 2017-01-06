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
use AppBundle\Form\Type\PersonalDataType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\MonthlyDuesType;
use AppBundle\Form\Type\YearInfoType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FinanceMemberType extends AbstractType {
    
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('memid', IntegerType::class, array('disabled' => true, 'label' => 'Mitgliedsnr.:'))
            ->add('personaldata', PersonalDataType::class, array(
        'data_class' => 'AppBundle\Entity\Mitglieder\Member',
        'pn_data_class' => 'AppBundle\Entity\MemPhoneNumber',
        'title_disabled' => true,
        'firstname_disabled' => true,
        'lastname_disabled' => true,
        'birthday_disabled' => true,
        'streetaddress_disabled' => true,
        'postcode_disabled' => true,
        'mailbox_disabled' => true,
        'location_disabled' => true,
        'phonenumber_disabled' => true,
        'email_disabled' => true
        
    ))
           
                
                ->add('sportsgroup', EntityType::class,  array(
            'class' => 'AppBundle:MemSportsgroup',
                    
            'choice_label' => 'token',
            'multiple' => true,
            'required' => false,
            'label' => 'Sportgruppe/n:',
            'disabled' => true
            
        ))
                ->add('admissioncharge', MoneyType::class)
                ->add('admissionchargepayed', MoneyType::class, array('required' => false))
            
            ->add('monthlydues', CollectionType::class, array('entry_type' => MonthlyDuesType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\MemMonthlyDues')))
            ->add('yearinfo', CollectionType::class, array('entry_type' => YearInfoType::class, 'entry_options' => array('data_class' => 'AppBundle\Entity\MemYearInfo')))
            
    
            
                   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member',
        ));
    }
}
