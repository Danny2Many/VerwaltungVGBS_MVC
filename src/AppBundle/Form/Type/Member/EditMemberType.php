<?php



namespace AppBundle\Form\Type\Member;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditMemberType extends BaseMemberType{
   public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        parent::buildForm($builder, $options);
       $builder->add('tribute',SanitizedTextType::class, array('label' => 'Ehrung:', 'required' => false) )
               ->add('memid',SanitizedTextType::class, array('label' => 'Mitgliedsnummer:', 'required' => false, 'disabled' => true) )
               ->add('delete', SubmitType::class, array('attr' => array('class' => 'btn btn-danger'), 'label' => 'löschen'));   

    }
    
         public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'AppBundle\Entity\Member',
        'adyear' => NULL,
        
    ));
}
}
