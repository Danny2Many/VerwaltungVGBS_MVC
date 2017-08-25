<?php



namespace AppBundle\Form\Type\Mitglieder;



use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;



class AdvancedSearchType extends AbstractType{
    

    public $options;
    public function buildForm(FormBuilderInterface $builder, array $options)      
    {

        $this->options=$options;
        
        $membersportsgroupstate = array(
                'choices'  => array('eingeschrieben' => 'is', 'ausgetreten' => 'is not'),
                'choices_as_values' => true,
                'label' => 'Teilnahmeverhältnis:',
                'required' => false);
        
        if($options['relation'] == 'ausgetreten')
        {
            $membersportsgroupstate = array_merge($membersportsgroupstate, array('disabled' => true, 'data' => 'is not'));
        }
        $builder

                ->add('terminationdate',DateType::class, array('label' => 'RS gültig bis:', 
                    'format' => 'yyyy-MM-dd', 
                    'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 
                    'required' => false,
                    'invalid_message' => 'Bitte geben Sie ein gültiges Datum an.'))
                
                ->add('rehabunits',IntegerType::class, array('label' => 'Einheiten', 
                    'required' => false))
              
                ->add('terminationdatecompoperators', ChoiceType::class, array(
                'choices'  => array(
                'am' => '=',
                'vor' => '<',
                'nach' => '>'
                ),
                'choices_as_values' => true,
                'label' => 'Läuft ab:',
                'required' => false
                ))

                ->add('rehabunitscompoperators', ChoiceType::class, array(
                'choices'  => array(
                '=' => '=',
                '<' => '<',
                '>' => '>',
                '<=' => '<=',
                '>=' => '>='

                ),
                'choices_as_values' => true,
                'label' => 'besitzt:',
                'required' => false
                ))
                
                ->add('sportsgroup', EntityType::class, array(
                        'class' => 'AppBundle:Sportsgroup',
                        'choice_label' => 'token',
                        'label' => 'Name:',
                        'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                        ->where('s.type=\''.$this->options['typeSymbol'].'\'');
                        },
                        'required' => false
                    ))
                                

                              
                ->add('membersportsgroupstate', ChoiceType::class, $membersportsgroupstate)                                
               
                ->add('search', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'Suchen'))
                ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'Abbrechen'))
                ->add('reset', ButtonType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'Zurücksetzen'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'typeSymbol'=>null,
            'relation' => null
        ));
    }

    
}
