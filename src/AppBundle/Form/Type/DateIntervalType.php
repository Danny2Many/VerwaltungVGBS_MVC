<?php



namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DateIntervalType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add($options['beginColName'],DateType::class, array('label' => $options['beginLabel'], 'format' => 'yyyy-MM-dd', 'required' => $options['beginRequired'], 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add($options['endColName'],DateType::class, array('label' => $options['endLabel'], 'format' => 'yyyy-MM-dd', 'required' => $options['endRequired'],'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'beginColName' => null,
            'endColName' => null,
            'beginLabel' => 'Beginn:',
            'endLabel' => 'Ende:',
            'beginRequired' => true,
            'endRequired' => false
            
        ));
    }
}
