<?php
namespace AppBundle\Form\Type\Nichtmitglieder;

use AppBundle\Form\Type\Nichtmitglieder\BaseNonMemberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddNonMemberType extends BaseNonMemberType {
    
    public function configureOptions(OptionsResolver $resolver, array $options)
        {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Nichtmitglieder\Nonmember',
            'adyear' => NULL,


));

}
}