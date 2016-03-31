<?php



namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RehabCertType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('terminationdate',DateType::class, array('label' => 'RS gültig bis:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('rehabunits',IntegerType::class, array('label' => 'Einheiten:'));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL,
        ));
    }
}
