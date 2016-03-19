<?php



namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Form\SanitizedTextType;

class YearInfoType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('levy',MoneyType::class, array('label' => 'Umlage:'))
                ->add('additionalduesinfo',  SanitizedTextType::class, array('label' => 'zusätzl. Beitragsinfo'));
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NULL,
        ));
    }
}
