<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\MemSportsgroup;
use AppBundle\Entity\Trainer\Trainer;
use AppBundle\Entity\Trainer_MemSportsgroupSub;
use AppBundle\Entity\Member_Sportsgroup;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\BSSACert;
use Doctrine\ORM\EntityManager;
use AppBundle\Form\Type\Sportsgroup\AddSportsgroupType;
use AppBundle\Form\Type\Sportsgroup\BaseSportsgroupType;
use AppBundle\Services\IndexManager;
use AppBundle\Services\FunctionManager;


class MemSportsgroupController extends Controller {

    /**
    * @Route("/mitgliedersportgruppen/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016}, name="memsportsgroup_home" , requirements={"letter": "[A-Z]|alle", "adminyear": "[1-9][0-9]{3}"})
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
    $dependencies=array('MemSportsgroup', 'BSSACert', 'Member', 'Trainer_MemSportsgroupSub' , 'Trainer\Trainer', 'Member_Sportsgroup', 'Rooms');
    $qb=[];
       foreach($dependencies as $dependent){
  
           $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear);   
    } 
    
    $choices=array('Gruppenbezeichnung' => 'token',
                   'Sportgruppe/Info' => 'name',
                   'Wochentag' => 'day'
        
        );
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('memsportsgroup_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
      //building the query
    $qb['MemSportsgroup']->andWhere($qb['MemSportsgroup']->expr()->like('ditto.'.$searchcol, ':sportsgroup'))

                   ->setParameter('sportsgroup','%'.$searchval.'%')
                   ->getQuery();
    
       
    }
     else if ($letter !='alle')
    {
        $qb['MemSportsgroup']->andWhere($qb['MemSportsgroup']->expr()->like('ditto.name', ':letter'))
                  ->setParameter('letter',$letter.'%');



         switch($letter){
           case 'A': $qb['MemSportsgroup']->orWhere($qb['MemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ä%'); 
           break;

           case 'O': $qb['MemSportsgroup']->orWhere($qb['MemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ö%'); 
           break;

           case 'U': $qb['MemSportsgroup']->orWhere($qb['MemSportsgroup']->expr()->like('ditto.name', ':umlautletter'))
                        ->setParameter('umlautletter','Ü%'); 
           break;
       }
    }else{ $letter=null; } 
    $sportsgrouplist=$qb['MemSportsgroup']->getQuery()->getResult();
    $bssacertlist=$qb['BSSACert']->getQuery()->getResult();
    $sportgrouptrainerlist=$qb['Trainer_MemSportsgroupSub']->getQuery()->getResult();
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    $memberlist=$qb['Member']->getQuery()->getResult();
    $sportsgroupnonmemberlist=$qb['Member_Sportsgroup']->getQuery()->getResult();
    $roomlist=$qb['Rooms']->getQuery()->getResult();
    
    $sportsgroupdependentlist=[];
    foreach ($bssacertlist as $bs){
        $sportsgroupdependentlist[$bs->getSgid()]['terminationdate'][]=$bs;  
        $sportsgroupdependentlist[$bs->getSgid()]['startdate'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['validfrom'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['groupnr'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['bssacertnr'][]=$bs; 
    }
     foreach ($roomlist as $ro){
        
        $sportsgroupdependentlist[$ro->getRoomid()]['rooms'][]=$ro; 
        
    }
    
    foreach ($trainerlist as $tr){
        
        $sportsgroupdependentlist[$tr->getTrainerid()]['trainers'][]=$tr; 
        
    }
    
    //Total Number of Nonmembers per Sportsgroup
    //by Adding a string 'Danny' to an Array.
    //Count the number of entries in the Array
    foreach ($sportsgroupnonmemberlist as $sn){
        $sportsgroupdependentlist[$sn->getSgid()]['memberstotal'][$sn->getNmemid()]='Danny';   
    }
    
    foreach ($sportsgroupnonmemberlist as $sm){
    $sportsgroupdependentlist[$sm->getSgid()]['members'][$sm->getNmemid()]=0;
    }
        
    foreach ($sportsgrouplist as $sg){
        foreach ($memberlist as $nm){               
           
                if(isset($sportsgroupdependentlist[$sg->getSgid()]['members'][$nm->getMemid()])){                    
                     if ($nm->getTitle() === 0 ){
                     if(!isset($sportsgroupdependentlist[$sg->getSgid()]['members']['female']))$sportsgroupdependentlist[$sg->getSgid()]['members']['female']=0;    
                    $sportsgroupdependentlist[$sg->getSgid()]['members']['female']+=1;
                }else if($nm->getTitle() === 1 ) {
                    if(!isset($sportsgroupdependentlist[$sg->getSgid()]['members']['male']))$sportsgroupdependentlist[$sg->getSgid()]['members']['male']=0;    
                    $sportsgroupdependentlist[$sg->getSgid()]['members']['male']+=1;       
                    }
                }
        }
    }

    //Substitute Teacher per Sportsgroup
    foreach ($sportgrouptrainerlist as $pn){
        $sportsgroupdependentlist[$pn->getSgid()]['trainersub'][$pn->getTrainerid()]=$pn->getTrainerid();
    }
    
   foreach ($sportsgrouplist as $sg){
           foreach ($trainerlist as $tr){
               if(isset($sportsgroupdependentlist[$sg->getSgid()]['trainersub'][$tr->getTrainerid()])){
               $sportsgroupdependentlist[$sg->getSgid()]['trainersub'][$tr->getTrainerid()]=$tr; 
               }
    }
   }
   
   
     
     
     
    return $this->render(
     'Sportgruppen/memsportsgroup.html.twig',
     array(              
         'colorclass' => "bluetheader",
         'searchform' => $searchform->createView(),
         'sportsgroupdependentlist' => $sportsgroupdependentlist,
         'cletter' => $letter,
         'adminyear' => $adminyear,
         'tabledata' => $sportsgrouplist, 
         'path' => 'memsportsgroup_home'
         ));
}

//**********************************************************************************************************

    /**
     * @Route("/mitgliedersportgruppen/anlegen/{adminyear}/{letter}", defaults={"letter": "alle", "adminyear": 2016}, name="addmemsportsgroup", requirements={"letter": "[A-Z]|alle" ,"adminyear": "[1-9][0-9]{3}"})
     * 
     */
     public function addsportsgroupAction (Request $request, $letter, $adminyear){
     
     $doctrine=$this->getDoctrine();   
     $manager= $doctrine->getManager();
     $memsportsgroup = new MemSportsgroup();
     $bssacert = new BSSACert();
     $trainer = new Trainer();
     
//     $im=  $this->get('app.index_manager')
//                   ->setEntityName('Sportsgroup');
     
//     $im= new IndexManager($manager, 'Sportsgroup');
     $fm= new FunctionManager($doctrine, $adminyear);
//     $sgid=$im->getCurrentIndex();
     $memsportsgroup->setSgid(uniqid('sg'));

     $memsportsgroup->addBssacert($bssacert);
     
     $addmemsportsgroupform = $this->createForm(BaseSportsgroupType::class, $memsportsgroup, array('adyear' => $adminyear)); 
     $addmemsportsgroupform->handleRequest($request);
     
     if($addmemsportsgroupform->isSubmitted() && $addmemsportsgroupform->isValid()){
        
         
        $memsportsgroup->setValidfrom($adminyear)
                    ->setValidto('2155');  
        
        $memsportsgroup->setTrainerid($memsportsgroup->getTrainer()->getTrainerid());
        
        foreach($memsportsgroup->getBssacert() as $bs){
                $bs->setBssaid(uniqid('bs'))
           ->setValidfrom($adminyear)
           ->setValidto('2155');       
        $manager->persist($bs);}
        
        foreach ($memsportsgroup->getSubstitute() as $su){
                $fm->AddObject($su,'secondary', array('entitypath' => 'AppBundle\Entity\Trainer_MemSportsgroupSub','idprefixone' => 'sg','idone' => $memsportsgroup->getSgid()));
            }
            
        $manager->persist($memsportsgroup);
        $manager->flush();
        
//        $im->add();
        $this->addFlash('notice', 'Diese Nichtmitglieder-Sportgruppe wurde erfolgreich angelegt');
        return $this->redirectToRoute('memsportsgroup_home', array('letter'=>$letter, 'adminyear' => $adminyear));
     }
     
    return $this->render(
      'Sportgruppen/memsportsgroupform.html.twig',
      array(            
          'form' => $addmemsportsgroupform->createView(),
          'cletter' => $letter,
          'title' => 'Sportgruppe anlegen',
          'adminyear' => $adminyear
          ));
     }
    




}
