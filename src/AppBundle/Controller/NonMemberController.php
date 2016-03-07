<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NonMemberController extends Controller {
    /**
     * @Route("/nichtmitglieder/{letter}", defaults={"letter"="A"}, name="nonmember_home", requirements={"letter": "[A-Z]"})
    */    
    public function indexAction($letter) {   
  
        
    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Nichtmitglieder\Nonmember');
         
        return $this->render(
        'Nicht_Mitglieder/nonmember.html.twig',
        array(
            'info' => NULL,
            'cletter' => $letter,
            'tabledata' => NULL, 
            'path' => 'nonmember_home'
            ));
    }     
}

