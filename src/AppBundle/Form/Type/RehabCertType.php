<?php



namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RehabCertType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('terminationdate',DateType::class, array('label' => 'RS gültig bis:', 'required' => false, 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MemRehabilitationCertificate',
        ));
    }
}
