<?php

namespace AppBundle\Form\Type\Trainer;

use AppBundle\Form\Type\Trainer\AddTrainerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class EditTrainerType extends AddTrainerType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder->add('trainerid', IntegerType::class, array('label' => 'Trainernummer:', 'required' => false, 'disabled' => true))
                ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));
              
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Trainer\Trainer',));
    }
}

