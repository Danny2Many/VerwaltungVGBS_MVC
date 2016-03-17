<?php


namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\SanitizedEmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\PhoneNumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalDataType extends AbstractType{
    
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            
            ->add('title', ChoiceType::class, array(
    'choices'  => array(
        'Frau' => 'Frau',
        'Herr' => 'Herr',
        
    ),
    // *this line is important*
    'choices_as_values' => true,

    'label' => 'Anrede:',
    
))
            ->add('firstname', SanitizedTextType::class, array('label' => 'Vorname:'))
                          
            
             
            ->add('lastname', SanitizedTextType::class, array('label' => 'Name:'))
                    
            ->add('birthday', BirthdayType::class, array('label' => 'Geburtstag:', 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
            ->add('streetaddress', SanitizedTextType::class, array('label' => 'Strasse, Hausnr.:'))
                     
            ->add('postcode', SanitizedTextType::class, array('label' => 'Postleitzahl:'))
                    
            ->add('mailbox', SanitizedTextType::class, array('label' => 'Postfach:', 'required'=>false))
                    
            ->add('location', SanitizedTextType::class, array('label' => 'Ort:'))
                    
            ->add('phonenumber', CollectionType::class, array('entry_type' => PhoneNumberType::class, 'entry_options' => array('data_class' => $options['pn_data_class']), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
                     
            ->add('email', SanitizedEmailType::class, array('label' => 'E-Mail:', 'required' => false))
                   ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'pn_data_class' => NULL
        ));
    }
}
