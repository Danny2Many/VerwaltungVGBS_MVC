<?php



namespace AppBundle\Form\Type\Mitglieder;


use AppBundle\Form\Type\PersonalDataType;
use Symfony\Component\Form\FormBuilderInterface;



use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;


class AdvancedSearchType extends AbstractType{
  
    public function buildForm(FormBuilderInterface $builder, array $options)      
    {

        $builder

                ->add('terminationdate',DateType::class, array('label' => 'RS gültig bis:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag'), 'required' => false))
                ->add('rehabunits',IntegerType::class, array('label' => 'Einheiten', 'required' => false))
              
                ->add('terminationdatecompoperators', ChoiceType::class, array(
                'choices'  => array(
                'am' => 'am',
                'vor' => 'vor',
                'nach' => 'nach'
                ),
                'choices_as_values' => true,
                'label' => 'Läuft ab:'
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
                'label' => 'mit:'
                ))
               
                ->add('search', SubmitType::class, array('attr' => array('class' => 'btn btn-primary'), 'label' => 'Suchen'))
                ->add('cancel', ButtonType::class, array('attr' => array('class' => 'btn btn-default'), 'label' => 'Abbrechen'))
                ->add('reset', ButtonType::class, array('attr' => array('class' => 'btn btn-warning'), 'label' => 'Zurücksetzen'));

    }



    
}
