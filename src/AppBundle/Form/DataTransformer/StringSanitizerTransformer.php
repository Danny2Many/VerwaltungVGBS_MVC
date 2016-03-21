<?php

namespace AppBundle\Form\DataTransformer;



use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class StringSanitizerTransformer implements DataTransformerInterface{
    
    
    
    public function transform($original)
    {
        $output = strip_tags($original);
        return htmlspecialchars($output);
    }
    
    
    public function reverseTransform($submitted)
    {
        
       return strip_tags($submitted);
    }
}
