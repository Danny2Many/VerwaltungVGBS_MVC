<?php



namespace AppBundle\Form\Type\Member;

use AppBundle\Form\Type\Member\BaseMemberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class AddMemberType extends BaseMemberType {
    
   
    
    public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        parent::buildForm($builder, $options);
        $builder->add('admissioncharge', MoneyType::class, array('mapped' => false, 'label' => 'Aufnahmegebühr:'))
                ->add('dues', MoneyType::class, array('mapped' => false, 'label' => 'Monatlicher Beitr:'));
          

    }
    
         public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'AppBundle\Entity\Member',
        
    ));
}
}
