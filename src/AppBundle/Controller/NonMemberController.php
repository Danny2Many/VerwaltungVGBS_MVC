<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Request;

class NonMemberController extends Controller
{
    /**
     * @Route("/nichtmitglieder", name="nonmember_home")
     */
    public function indexAction () {
    
        return $this->render('Nicht_Mitglieder/nonmember.html.twig', 
        array('cletter'=>NULL, 'info'=>NULL, 'tabledata' => NULL, 'path'=> 'nonmember_home'));
    }
}
=======

use AppBundle\Entity\Nichtmitglieder\Nonmember;

class NonMemberController extends Controller {
    /**
     * @Route("/nichtmitglieder/{letter}/{info}", defaults={"letter"="A", "info"=null}, name="nonmember_home", requirements={"info": "null", "letter": "[A-Z]"})
    */    
    public function indexAction($letter, $info) {   
  
      
    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Nichtmitglieder\Nonmember');
    
   // $qb=$repository->createQueryBuilder('n');
    
        return $this->render(
        'Nicht_Mitglieder/nonmember.html.twig',
        array('info' => $info,
            'colorclass' => "bluetheader",
            'cletter' => $letter,
            'tabledata' => NULL, 
            'path' => 'nonmember_home'
            ));
    }     
}

>>>>>>> refs/remotes/origin/Eddy_Branch
