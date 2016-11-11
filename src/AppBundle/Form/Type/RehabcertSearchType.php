<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RehabcertSearchType extends AbstractType
{
   public $choices;
   

   
       public function buildForm(FormBuilderInterface $builder, array $options)
    {

       
        $builder
            

            ->add('terminationdate', DateType::class);
  
            
            
            
        
    }
   
public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        
        'choices' => null
    ));
}

}

