<?php



namespace AppBundle\Form\Type\Sportsgroup;
use AppBundle\Form\Type\Sportsgroup\BaseSportsgroupType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class  AddSportsgroupType extends BaseSportsgroupType {
    
    public function configureOptions(OptionsResolver $resolver)
        {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup',

));

}
}
