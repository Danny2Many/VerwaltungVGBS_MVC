<?php


namespace AppBundle\Form\Type\Dues;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ChooseDuesType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        
                $builder->add('paystart',DateType::class, array('label' => 'Zahlungsbeginn:', 'format' => 'yyyy-MM-dd', 'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                        ->add('payend',DateType::class, array('label' => 'Zahlungsende:', 'format' => 'yyyy-MM-dd', 'required' => false,'placeholder' => array('year' => 'Jahr', 'month' => 'Monat', 'day' => 'Tag')))
                        ->add('due', EntityType::class, array(
                                'class' => 'AppBundle:Beitraege\Dues',
                                'choice_label' => function ($due) {
                                    return $due->getName();
                                },
                                'query_builder' => function (EntityRepository $er) {
                                return $er->createQueryBuilder('d')
                                    ->orderBy('d.type', 'ASC');
                                },
                                'label' => 'Beitrag:',
                                'group_by' => function($due) {
                                    if ($due->getType() == 0) 
                                    {
                                        return 'Standart';
                                    } 
                                    else 
                                    {
                                        return 'Angepasst';
                                    }
                                },
                                'choice_attr' => function($due) {
                                return ['data-toggle'=>"tooltip", "data-placement"=>"auto", 'title'=>'Beschreibung: '.$due->getDescription()];
                            },
                            )) ;
    }
    
    public function configureOptions(OptionsResolver $resolver){
    $resolver->setDefaults(array(
        'data_class' => "AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues"

    ));
}
}
