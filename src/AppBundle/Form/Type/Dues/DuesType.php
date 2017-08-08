<?php

namespace AppBundle\Form\Type\Dues;

use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\SanitizedTextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Type\Dues\DuesPriceType;

class DuesType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        if($options['isEdit']==true){
            $builder->add('dueid',SanitizedTextType::class, array('label' => 'Beitragsnummer:', 'required' => false, 'disabled' => true))
                    ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));
        }
        
        $builder->add('type', ChoiceType::class, array(
    'choices'  => array(
        'Standart' => 0,
        'Angepasst' => 1,

        
    ),
   
    'choices_as_values' => true,
    'label' => 'Art:'
    
))
                ->add('state', ChoiceType::class, array(
    'choices'  => array(
        'Aktuell' => 0,
        'Veraltet' => 1,

        
    ),
   
    'choices_as_values' => true,
    'label' => 'Status:'
    
))
                ->add('duescharge', CollectionType::class, array('entry_type' => DuesPriceType::class, 
                    'entry_options' => array('data_class' => 'AppBundle\Entity\Beitraege\DuesPrice'), 
                    'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
                ->add('name', SanitizedTextType::class, array('label' => 'Name:', 'required' => true))
                ->add('description', SanitizedTextareaType::class, array('label' => 'Beschreibung:', 'required' => false))
                ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
                ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
                ->add('reset', ButtonType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));
    }
    
             public function configureOptions(OptionsResolver $resolver){
    $resolver->setDefaults(array(
        'data_class' => "AppBundle\Entity\Beitraege\Dues",
        'isEdit' => false

    ));
}
}
