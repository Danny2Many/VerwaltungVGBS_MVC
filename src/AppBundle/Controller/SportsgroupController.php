<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\BSSACert;


class SportsgroupController extends Controller {
    /**
    * @Route("/sportgruppen/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="sportsgroup_home" , requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})
    */ 
     public function indexAction (Request $request, $letter, $adminyear){
         
    $doctrine = $this->getDoctrine();
    $dependencies=['Nichtmitglieder\NonMemSportsgroup', 'BSSACert'];
    $qb=[];
    foreach($dependencies as $dependent){
     
        $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
        $qb[$dependent]->select(array('ditto', $qb[$dependent]->expr()->max('ditto.recorded')))
                ->where('ditto.recorded <= :year')
                ->groupBy('ditto.sgid')
                ->setParameter('year', $adminyear.'-12-31');
    }
    
    $choices=array('Sportgruppennr.' => 'sgid');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('sportsgroup_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
      //building the query
    $qb['Nichtmitglieder\NonMemSportsgroup']->where($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.'.$searchcol, ':sportsgroup'))

                   ->setParameter('sportsgroup','%'.$searchval.'%')
                   ->getQuery();
    
       
    }
     else
    {
        $qb['Nichtmitglieder\NonMemSportsgroup']->andWhere($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.name', ':letter'))
                  ->setParameter('letter',$letter.'%');



         switch($letter){
           case 'A': $qb['Nichtmitglieder\NonMemSportsgroup']->orWhere($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ä%'); 
           break;

           case 'O': $qb['Nichtmitglieder\NonMemSportsgroup']->orWhere($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ö%'); 
           break;

           case 'U': $qb['Nichtmitglieder\NonMemSportsgroup']->orWhere($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ü%'); 
           break;
       }
    }
    $sportsgrouplist=$qb['Nichtmitglieder\NonMemSportsgroup']->getQuery()->getResult();
    $bssacertlist=$qb['BSSACert']->getQuery()->getResult();
    
    $sportsgroupdependentlist=[];
    foreach ($bssacertlist as $td){
        $sportsgroupdependentlist[$rc[0]->getMemid()]['terminationdate'][]=$td;        
    }
     
     
    return $this->render(
     'Sportgruppen/sportsgroup.html.twig',
     array(              
         'colorclass' => "bluetheader",
         'searchform' => $searchform->createView(),
         'sportsgroupdependentlist' => $sportsgroupdependentlist,
         'cletter' => $letter,
         'adminyear' => $adminyear,
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