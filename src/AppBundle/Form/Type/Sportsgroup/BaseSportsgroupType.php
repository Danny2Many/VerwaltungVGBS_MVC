<?php
namespace AppBundle\Form\Type\Sportsgroup;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\BSSACertType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class BaseSportsgroupType extends AbstractType{
    protected $adminyear;
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $this->adminyear=$options['adyear'];
        $builder
        
        ->add('name', SanitizedTextType::class, array ('label' => 'Sportgruppe:'))
        ->add('trainer', EntityType::class, array (
            'class' => 'AppBundle:Trainer\Trainer',
            'choice_label' =>array('lastname', 'firstname'),
            'required' => true,'label' => 'Übungsleiter:'))
                     
        ->add('substitute', EntityType::class, array(
                        'class' => 'AppBundle:Trainer\Trainer',
                        'choice_label' => 'lastname',
                        'multiple' => true,
                        'required' => false,
                        'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                                  ->where('s.validfrom <='.$this->adminyear)
                                  ->andWhere('s.validto >'.$this->adminyear);
                        }
                    ))        
        ->add('day', ChoiceType::class, array ('choices' => array ('Montag' =>'Montag', 'Dienstag' => 'Dienstag','Mittwoch' => 'Mittwoch', 'Donnerstag' => 'Donnerstag', 'Freitag' => 'Freitag'),
             'choices_as_values' => true,
            'label' => 'Wochentag:'))      
                            
         ->add('time', TimeType::class, array( 'label' => 'Uhrzeit:', 'widget' => 'choice', 'minutes' => array(00,05,10,15,20,25,30,35,40,45,50,55),'input'  => 'timestamp', 'with_seconds' => false, 'placeholder' => array('minute' => 'Minuten', 'hour' => 'Stunden')))
//       ->add('time', SanitizedTextType::class, array ('label' => 'Uhrzeit:'))
        ->add('roomid', SanitizedTextType::class, array ('label' => 'Räumlichkeiten:','required' => false))        
        ->add('capacity', SanitizedTextType::class, array ('label' => 'Kapazität:'))        
        ->add('info',SanitizedTextType::class, array ('label' => 'Info:','required' => false))
        ->add('token', SanitizedTextType::class, array ('label' => 'Gruppenbezeichnung:','required' => false))
        ->add('bssacert', CollectionType::class, array('entry_type' =>BSSACertType::class, 'entry_options'  => array('data_class'  => 'AppBundle\Entity\BSSACert'), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true,'required' => false))
       
        ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'speichern'))
        ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'abbrechen'))
        ->add('reset', ResetType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'zurücksetzen'));        
       
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'adyear' => NULL
        ));
    }
}
