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
     
    if($adminyear == date('Y')){ 
        $now=date("Y-m-d");
    }
     //else take the last day of the choosen year
    else{
        $now=$adminyear.'-12-31';
    }     
         
    $doctrine = $this->getDoctrine();
    $dependencies=array('Nichtmitglieder\NonMemSportsgroup' => 'sg', 'BSSACert' => 'bssa');
    $qb=[];
       foreach($dependencies as $dependent => $idprefix){
   
        //building the subquery: SELECT max(recorded) FROM % AS dittosub WHERE dittosub.type = ditto.type
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.recorded'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
                          
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$adminyear 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.recorded=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.recorded<=:adminyear')
                    ->setParameter('adminyear',$now);
    }
    $choices=array('Sportgruppennr.' => 'sgid');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('sportsgroup_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
      //building the query
    $qb['Nichtmitglieder\NonMemSportsgroup']->andWhere($qb['Nichtmitglieder\NonMemSportsgroup']->expr()->like('ditto.'.$searchcol, ':sportsgroup'))

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
    foreach ($bssacertlist as $bs){
        $sportsgroupdependentlist[$rc[0]->getBssaid()]['terminationdate'][]=$bs;        
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