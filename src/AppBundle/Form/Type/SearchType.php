<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchType extends AbstractType
{
   public $choices;
   

   
       public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->choices= $options['choices'];
       
        $builder
            
            ->setMethod('GET')
            ->add('column', ChoiceType::class, array(
    'choices'  => $this->choices,
    // *this line is important*
    'choices_as_values' => true,
    
))
            ->add('searchfield', TextType::class);
            
            
            
        
    }
   
public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        
        'choices' => null
    ));
}

}

