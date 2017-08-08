<?php


namespace AppBundle\Form\Type\Dues;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class DuesPriceType extends AbstractType{
         public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('price', MoneyType::class, array('label' => 'Preis:'))
                ->add('validfrom',DateType::class, array('label' => 'Gültig ab:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')));
                

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Beitraege\DuesPrice',
            'error_bubbling'=>false


            
        ));
    }
}
