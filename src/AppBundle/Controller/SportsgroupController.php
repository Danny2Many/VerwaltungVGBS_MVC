<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;


class SportsgroupController extends Controller {
    /**
    * @Route("/sportgruppen/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="sportsgroup_home" , requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"}})
    */ 
     public function indexAction (Request $request, $letter){
         
    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Nichtmitglieder\NonMemSportsgroup');
    
    $qb=$repository->createQueryBuilder('s');
    
    $choices=array('Sportgruppennr.' => 'sgid');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('sportsgroup_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
     
    $query=$qb->where($qb->expr()->like('s.'.$searchcol, ':sportsgroup'))
                   ->setParameter('sportsgroup','%'.$searchval.'%')
                   ->getQuery();
    $disabled=''; 
       
    }
     else
    {
        $query=$qb->where($qb->expr()->like('s.token', ':letter'))
                   ->setParameter('letter',$letter.'%');
        $sportsgrouplist=$query->getQuery()->getResult();
        $disabled='disabled';
        
    }
       return $this->render(
        'Sportgruppen/sportsgroup.html.twig',
        array(              
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'disabled' => $disabled,
            'cletter' => $letter,
            'tabledata' => $sportsgrouplist, 
            'path' => 'sportsgroup_home'
            ));
}
    /**
     * @Route("/sportgruppen/anlegen/{letter}", defaults={"letter": "A"}, name="addsportsgroup", requirements={"letter": "[A-Z]"})
     * 
     */
     public function addsportsgroupAction (Request $request, $letter){
     }
     
}