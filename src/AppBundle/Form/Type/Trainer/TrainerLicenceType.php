<?php

namespace AppBundle\Form\Type\Trainer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class TrainerLicenceType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('licencetype', SanitizedTextType::class, array('label' => 'Lizenz:'));
        $builder->add('licencenumber', SanitizedTextType::class, array('label' => 'Lizenz Nr.:'));
        $builder->add('issuedate', DateType::class, array('label' => 'Austellungs Datum:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Mon.', 'day' => 'Tag')));
        $builder->add('expirationdate', DateType::class, array('label' => 'Ablauf Datum:','format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Mon.', 'day' => 'Tag')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Trainer\TrainerLicence',
        ));
    }
}

