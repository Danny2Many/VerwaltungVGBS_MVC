<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;


class BSSACertType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
                ->add('terminationdate',SanitizedTextType::class, array('label' => 'Laufzeit bis:', 'disabled' => $options['terminationdate_disabled'], 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('startdate',SanitizedTextType::class, array('label' => 'Erstanmeldung:', 'disabled' => $options['startdate_disabled'], 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('groupnr', SanitizedTextType::class, array('label' => 'VGBS-GruppenNr.:'))
                ->add('bssacertnr', SanitizedTextType::class, array ('label' => 'BSSA-Zertifikatnr.:'))        
                
                ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL,
        ));
    }    
        
    
}
