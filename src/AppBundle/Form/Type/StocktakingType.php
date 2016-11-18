<?php

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StocktakingType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        //range from five years ago, to the current year 
        $range=range(Date('Y') - 5, date('Y'));
        $builder->add('stockdate',ChoiceType::class,array('choices'=> array_combine($range, $range),'label'=>'Inventurjahr:'))
                ->add('location', EntityType::class, array(
                      'class' => 'AppBundle:Room',
                      'choice_label' => 'roomname',
                      'multiple' => false,
                      'label' => 'Standort:'            
                      )) 
                ->add('state',ChoiceType::class,array('choices'=>array('neu'=>'neu',
                                                                       'gebraucht'=>'gebraucht',
                                                                       'sehr gut'=>'sehr gut',
                                                                       'gut'=>'gut',
                                                                       'befriedigend'=>'befriedigend',
                                                                       'schlecht'=>'schlecht',
                                                                       'sehr schlecht'=>'sehr schlecht',)
                               ,'choices_as_values' => true,'label'=>'Zustand:'))
                ->add('quantity',IntegerType::class,array('label'=>'Anzahl:'));
                
    } 
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => "\AppBundle\Entity\Inventory\Stocktaking"));
    }
}