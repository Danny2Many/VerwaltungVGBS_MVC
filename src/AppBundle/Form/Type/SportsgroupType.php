<?php



namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\DateIntervalType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SportsgroupType extends AbstractType{
    public $options;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;
        $builder->add('joined',DateType::class, array('label' => 'Beitritt:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('resignedfrom',DateType::class, array('label' => 'Austritt:', 'format' => 'yyyy-MM-dd', 'required' => false,'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('sportsgroup', EntityType::class, array(
     
                        'class' => 'AppBundle:Sportsgroup',
                        'choice_label' => 'token',
                        'label' => 'Sportgruppe:',
                    'query_builder' => function (EntityRepository $er) 
                                        {
                                            return $er->createQueryBuilder('s')
                                                ->where('s.type=\''.$this->options['typeSymbol'].'\'');
                                        },
                    )) 
                    ->add('periodOfRest', CollectionType::class, array('entry_type' => DateIntervalType::class, 
                        'entry_options' => array(
                            'data_class' => 'AppBundle\Entity\Mitglieder_NichtMitglieder\NonAndMemPeriodOfRest',
                            'beginColName'=>'restingbegin',
                            'endColName'=>'restingend',
                            ), 
                        'allow_add' => true, 'by_reference' => false, 
                        'allow_delete' => true, 'constraints' => array(new Valid())));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle/Entity/Mitglieder_NichtMitglieder/Member_Sportsgroup',
            'typeSymbol'=>null
        ));
    }
}
