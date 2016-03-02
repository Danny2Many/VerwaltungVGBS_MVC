<?php


namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\StringSanitizerTransformer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class SanitizedTextareaType extends AbstractType{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringSanitizerTransformer();
        $builder->addModelTransformer($transformer);
    }
    
    public function getParent()
    {
        return TextareaType::class;
    }
}
