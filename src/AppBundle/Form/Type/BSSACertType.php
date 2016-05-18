<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class BSSACertType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
                ->add('terminationdate',DateType::class, array('label' => 'Laufzeit bis:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Mon.', 'day' => 'Tag')))
                ->add('startdate',DateType::class, array('label' => 'Erstanmeldung:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Mon.', 'day' => 'Tag')))
                ->add('groupnr', SanitizedTextType::class, array('label' => 'VGBS-GruppenNr.:'))
                ->add('bssacertnr', SanitizedTextType::class, array ('label' => 'BSSA-Zertifikatnr.:'))        
                
                ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL,
            'disabled' => false
        ));
    }    
        
    
}
