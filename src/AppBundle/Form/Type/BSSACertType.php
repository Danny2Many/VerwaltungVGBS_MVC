<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;


class BSSACertType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
                ->add('terminationdate',SanitizedTextType::class, array('label' => 'Laufzeit bis:'))
                ->add('startdate',SanitizedTextType::class, array('label' => 'Erstanmeldung:'))
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
