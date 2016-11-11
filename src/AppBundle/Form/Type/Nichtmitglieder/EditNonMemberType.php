<?php

namespace AppBundle\Form\Type\Nichtmitglieder;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditNonMemberType extends BaseNonMemberType{
   public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        parent::buildForm($builder, $options);
       $builder->add('nmemid',IntegerType::class, array('label' => 'Nichtmitgliedsnummer:', 'required' => false, 'disabled' => true) )
               ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));
          

    }
    
         public function configureOptions(OptionsResolver $resolver)
        {$resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Nichtmitglieder\NonMember'));
        }
}


