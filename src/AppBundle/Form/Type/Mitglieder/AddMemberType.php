<?php



namespace AppBundle\Form\Type\Mitglieder;

use AppBundle\Form\Type\Mitglieder\BaseMemberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddMemberType extends BaseMemberType {
    
   
    
    public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        parent::buildForm($builder, $options);
        $builder->add('admissioncharge', MoneyType::class, array('label' => 'Aufnahmegebühr:'))
//                ->add('dues', MoneyType::class, array('mapped' => false, 'label' => 'Monatlicher Beitr:'));
          
                  ->add('decreaseddues', ChoiceType::class, array(
    'choices'  => array(
        'kein' => 0,
        'verminderter Beitrag' => 1,
        
    ),
    // *this line is important*
    'choices_as_values' => true,
    
    'label' => 'verminderter Beitrag:'
    
));

    }
    
         public function configureOptions(OptionsResolver $resolver){
    $resolver->setDefaults(array(
        'data_class' => "AppBundle\Entity\Mitglieder\Member",
        
    ));
}



}
