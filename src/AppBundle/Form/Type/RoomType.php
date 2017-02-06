<?php
namespace AppBundle\Form\Type;
use AppBundle\Form\SanitizedTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType {
   public function buildForm(FormBuilderInterface $builder, array $options)
    {  
     $builder->add('roomname',SanitizedTextType::class,array('label'=>'Raumname: '));            
    }
   
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => "\AppBundle\Entity\Room"));
    }
}
