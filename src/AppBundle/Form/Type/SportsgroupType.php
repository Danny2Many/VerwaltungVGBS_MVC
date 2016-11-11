<?php



namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SportsgroupType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('joined',DateType::class, array('label' => 'Beitritt:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('resignedfrom',DateType::class, array('label' => 'Austritt:', 'format' => 'yyyy-MM-dd', 'required' => false,'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('sportsgroup', EntityType::class, array(
                        'class' => 'AppBundle:Sportsgroup',
                        'choice_label' => 'token',
                        'label' => 'Sportgruppe:'
                    )) ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle/Entity/Mitglieder/Member_Sportsgroup',
        ));
    }
}
