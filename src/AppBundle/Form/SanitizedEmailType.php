<?php
namespace AppBundle\Form;
use AppBundle\Form\DataTransformer\StringSanitizerTransformer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;



class SanitizedEmailType extends AbstractType{
    
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringSanitizerTransformer();
        $builder->addModelTransformer($transformer);
    }
    
    public function getParent()
    {
        return EmailType::class;
    }
}
