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
    * @Route("/sportgruppen/{letter}", defaults={"letter"="A"}, name="sportsgroup_home")
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
            'searchform' => $searchform->createView(),
            'cletter' => $letter,
            'tabledata' => $sportsgrouplist, 
            'path' => 'sportsgroup_home'
            ));
}
}