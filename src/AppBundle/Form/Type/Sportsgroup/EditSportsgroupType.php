<?php
namespace AppBundle\Form\Type\Sportsgroup;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditSportsgroupType extends BaseSportsgroupType {
    public function buildForm(FormBuilderInterface $builder, array $options){
        parent::buildForm($builder, $options);
        $builder->add('sgid',IntegerType::class, array('label' => 'Sportgruppennummer:', 'required' => false, 'disabled' => true) )
                ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));
          
    }
    public function configureOptions(OptionsResolver $resolver)
        {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Sportsgroup'));
        }
}
