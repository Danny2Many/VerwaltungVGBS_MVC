<?php

namespace AppBundle\Form\Type\Trainer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;


class TrainerFocusType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('focus', SanitizedTextType::class, array('label' => 'Schwerpunkt:', 'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Trainer\TrainerFocus',
        ));
    }
}