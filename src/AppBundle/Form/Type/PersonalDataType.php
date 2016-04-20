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

        'Frau' => '0',
        'Herr' => '1',
        
    ),
    // *this line is important*
    'choices_as_values' => true,

    'label' => 'Anrede:',
    'disabled' => $options['title_disabled']
    
))
            ->add('firstname', SanitizedTextType::class, array('label' => 'Vorname:', 'disabled' => $options['firstname_disabled']))
                          
            
             
            ->add('lastname', SanitizedTextType::class, array('label' => 'Name:', 'disabled' => $options['lastname_disabled']))
                    
            ->add('birthday', BirthdayType::class, array('label' => 'Geburtstag:','disabled' => $options['birthday_disabled'], 'widget' => 'choice', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
            ->add('streetaddress', SanitizedTextType::class, array('label' => 'Strasse, Hausnr.:', 'disabled' => $options['streetaddress_disabled']))
                     
            ->add('postcode', SanitizedTextType::class, array('label' => 'Postleitzahl:', 'disabled' => $options['postcode_disabled']))
                    
            ->add('mailbox', SanitizedTextType::class, array('label' => 'Postfach:', 'required'=>false, 'disabled' => $options['mailbox_disabled']))
                    
            ->add('location', SanitizedTextType::class, array('label' => 'Ort:', 'disabled' => $options['location_disabled']))
                    
            ->add('phonenumber', CollectionType::class, array('entry_type' => PhoneNumberType::class, 'entry_options' => array('data_class' => $options['pn_data_class'], 'disabled'  => $options['phonenumber_disabled']), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
                     
            ->add('email', SanitizedEmailType::class, array('label' => 'E-Mail:', 'required' => false, 'disabled' => $options['email_disabled']))

                   ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'pn_data_class' => NULL,
            'title_disabled' => false,
            'firstname_disabled' => false,
            'lastname_disabled' => false,
            'birthday_disabled' => false,
            'streetaddress_disabled' => false,
            'postcode_disabled' => false,
            'mailbox_disabled' => false,
            'location_disabled' => false,
            'phonenumber_disabled' => false,
            'email_disabled' => false
        ));
    }
}
