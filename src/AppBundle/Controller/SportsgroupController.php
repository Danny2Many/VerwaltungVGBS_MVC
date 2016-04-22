<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup;
use AppBundle\Entity\Trainer\Trainer;
use AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\BSSACert;


class SportsgroupController extends Controller {
    /**
    * @Route("/sportgruppen/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016}, name="sportsgroup_home" , requirements={"letter": "[A-Z]|alle", "adminyear": "[1-9][0-9]{3}"})
    */ 
     public function indexAction (Request $request, $letter, $adminyear){
     
    if($adminyear == date('Y')){ 
        $now=date("Y");
    }
     //else take the last day of the choosen year
    else{
        $now=$adminyear;
    }     
         
    $doctrine = $this->getDoctrine();
    $dependencies=array('Nichtmitglieder\NonMemSportsgroup' => 'sg', 'BSSACert' => 'bssa', 'Nichtmitglieder\Trainer_NonMemSportsgroupSub' => 'trainer');
    $qb=[];
       foreach($dependencies as $dependent => $idprefix){
   
        //building the subquery: SELECT max(validfrom) FROM % AS dittosub WHERE dittosub.type = ditto.type
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.validfrom'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
                          
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.validfrom=( subquery ) AND ditto.validfrom<=$adminyear 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.validfrom<=:adminyear')
                    ->andWhere('ditto.validto>:adminyear')
                    ->setParameter('adminyear',$now);
    }
    $choices=array('Sportgruppennr.' => 'sgid',
                   'Gruppenbezeichnung' => 'token',
                   'Sportgruppe/Info' => 'name'
        
        );
    
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
     else if ($letter !='alle')
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
    }else{ $letter=null; } 
    //$qb['Trainer\Trainer'] = $doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy('trainerid');
    $sportsgrouplist=$qb['Nichtmitglieder\NonMemSportsgroup']->getQuery()->getResult();
    $bssacertlist=$qb['BSSACert']->getQuery()->getResult();
    $trainerlist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();
    
    $sportsgroupdependentlist=[];
    foreach ($bssacertlist as $bs){
        $sportsgroupdependentlist[$bs->getSgid()]['terminationdate'][]=$bs;  
        $sportsgroupdependentlist[$bs->getSgid()]['startdate'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['validfrom'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['groupnr'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['bssacertnr'][]=$bs; 
    }
    
    foreach ($trainerlist as $pn){

        $sportsgroupdependentlist[$pn->getSgid()]['trainers'][]=$pn;
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
     * @Route("/sportgruppen/anlegen/{adminyear}/{letter}", defaults={"letter": "alle", "adminyear": 2016}, name="addsportsgroup", requirements={"letter": "[A-Z]|alle" ,"adminyear": "[1-9][0-9]{3}"})
     * 
     */
     public function addsportsgroupAction (Request $request, $letter, $adminyear){
     
     $nonmemsportsgroup = new NonMemSportsgroup();
     $bssacertnr = new BSSACert();
     $trainers = new Trainer_NonMemSportsgroupSub();
     $im=  $this->get('app.index_manager')

                   ->setEntityName('Sportsgroup');
     $sgid=$im->getCurrentIndex();
     $nonmemsportsgroup->setSgid($sgid);
     $nonmemsportsgroup->addBssacert($bssacertnr);
     $nonmemsportsgroup->addTrainers($trainers);
     
     $addnonmemsportsgroupform = $this->createForm(AddSportsgroupType::class, $nonmemsportsgroup); 
     $addnonmemsportsgroupform->handleRequest($request);
     
     if($nonmemsportsgroup->isSubmitted() && $nonmemsportsgroup->isValid()){
         
        $manager= $this->getDoctrine()->getManager();
        $nonmemsportsgroup->setValidfrom($adminyear)
                    ->setValidto('2155');  

        $bs->setbssacertnr(uniqid($bs))
           ->Validfrom($adminyear)
           ->Validto('2155');       
        $manager->persist($bs);
        
        $manager->persist($nonmemsportsgroup);
        $manager->flush();
        
        $im->add();
        $this->addflash('notice', 'Diese Nichtmitglieder-Sportgruppe wurde erfolgreich angelegt');
         
        return $this->redirectRoute('sportsgroup_home', array('letter'=>$letter));
     }
     
    return $this->render(
      'Sportgruppen/sportsgroupform.html.twig',
      array(            
          'form' => $addnonmemsportsgroupform->createView(),
          'cletter' => $letter,
          'title' => 'Sportgruppe anlegen',
          'adminyear' => $adminyear
          ));
     }
     
     
     
     
     
}
