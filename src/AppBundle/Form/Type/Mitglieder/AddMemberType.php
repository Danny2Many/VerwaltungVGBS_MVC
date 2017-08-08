<?php



namespace AppBundle\Form\Type\Mitglieder;

use AppBundle\Form\Type\Mitglieder\BaseMemberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\Dues\ChooseDuesType;

class AddMemberType extends BaseMemberType {
    
   
    
    public function buildForm(FormBuilderInterface $builder, array $options)
        
    {
        parent::buildForm($builder, $options);
        $builder->add('admissioncharge', MoneyType::class, array('label' => 'Aufnahmegebühr:'))
                ->add('due', EntityType::class, array(
                                'class' => 'AppBundle:Beitraege:Dues',
                                'choice_label' => 'name',
                                'multiple' => false,
                                'expanded' => false,
                    ))

                ->add('due', CollectionType::class, array('entry_type' => ChooseDuesType::class, 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true));

    }
    
         public function configureOptions(OptionsResolver $resolver){
            $resolver->setDefaults(array(
                'data_class' => "AppBundle\Entity\Mitglieder_NichtMitglieder\Member",
                'typeSymbol'=>null
        
    ));
}



}
