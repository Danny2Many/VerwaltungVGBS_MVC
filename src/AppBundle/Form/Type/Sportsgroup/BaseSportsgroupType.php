<?php
namespace AppBundle\Form\Type\Sportsgroup;
use Doctrine\DBAL\Types\TextType;
use AppBundle\Form\SanitizedTextType;
use AppBundle\Form\Type\BSSACertType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;

class BaseSportsgroupType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        
        ->add('name', TextType::class, array ('label' => 'Sportgruppe:'))
        ->add('day', ChoiceType::class, array ('choices' => array ('Montag' =>'Montag', 'Dienstag' => 'Dienstag','Mittwoch' => 'Mittwoch', 'Donnerstag' => 'Donnerstag', 'Freitag' => 'Freitag'),
             'choices_as_values' => true,
            'label' => 'Wochentag:') )
        ->add('time', TextType::class, array ('label' => 'Uhrzeit:'))
        ->add('info',TextType::class, array ('label' => 'Info:'))
        ->add('token', TextType::class, array ('label' => 'Gruppenbezeichnung:'))
        
         ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
          ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
          ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));        
     ;   
    }
}
