<?php
namespace AppBundle\Form\Type\Sportsgroup;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Type\BSSACertType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;

class BaseSportsgroupType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        
        ->add('name', SanitizedTextType::class, array ('label' => 'Sportgruppe:'))
        ->add('day', ChoiceType::class, array ('choices' => array ('Montag' =>'Montag', 'Dienstag' => 'Dienstag','Mittwoch' => 'Mittwoch', 'Donnerstag' => 'Donnerstag', 'Freitag' => 'Freitag'),
             'choices_as_values' => true,
            'label' => 'Wochentag:'))
        ->add('time', SanitizedTextType::class, array ('label' => 'Uhrzeit:'))
        ->add('info',SanitizedTextType::class, array ('label' => 'Info:'))
        ->add('token', SanitizedTextType::class, array ('label' => 'Gruppenbezeichnung:'))
//        ->add('bssacert', CollectionType::class, array('entry_type' =>BSSACertType::class, 'entry_options'  => array('data_class'  => 'AppBundle\Entity\BSSACert'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true, ))
       
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));        
       
    }
}
