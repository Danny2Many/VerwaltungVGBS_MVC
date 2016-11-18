<?php

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Form\SanitizedTextType;

class ObjectOrderType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder->add('invoicenumber',SanitizedTextType::class, array('label' => 'Vereins Beleg Nr.:','required'=>false))
                ->add('orderdate',DateType::class,array('label'=>'Bestelldatum:','years'=>range(2004, date('Y')),'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                ->add('orderprice',MoneyType::class,array('label'=>'Preis:','required'=>false))
                ->add('quantity',IntegerType::class,array('label'=>'Anzahl:'))
                ->add('company',SanitizedTextType::class,array('label'=>'Firma/Hersteller:','required'=>false))
                ;
    }                
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => "\AppBundle\Entity\Inventory\ObjectOrder"));
    }
}

