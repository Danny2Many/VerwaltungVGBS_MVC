<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup;
use AppBundle\Entity\Trainer\Trainer;
use AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub;
use AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\BSSACert;
use Doctrine\ORM\EntityManager;
use AppBundle\Form\Type\Sportsgroup\EditSportsgroupType;
use AppBundle\Form\Type\Sportsgroup\BaseSportsgroupType;
use AppBundle\Services\IndexManager;

use AppBundle\Services\FunctionManager;

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
    $dependencies=array('Nichtmitglieder\NonMemSportsgroup', 'BSSACert', 'Nichtmitglieder\Nonmember', 'Nichtmitglieder\Trainer_NonMemSportsgroupSub' , 'Trainer\Trainer', 'Nichtmitglieder\NonMember_Sportsgroup', 'Rooms');
    $qb=[];
       foreach($dependencies as $dependent){
  
           $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear);   
    } 
// 
//$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Nichtmitglieder\Nonmember');
//$title='0';
//$sb = $repository->createQueryBuilder('t')
//->select('count(t)')
//->where('t.title =:title')
//->setParameter('title', $title);
//$nombre = $sb->getQuery()->getSingleScalarResult();
//
//
//    echo '<pre>';
//     print_r($nombre);
//     echo '</pre>';
    
    $choices=array('Gruppenbezeichnung' => 'token',
                   'Sportgruppe/Info' => 'name',
                   'Wochentag' => 'day'
        
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
    $sportsgrouplist=$qb['Nichtmitglieder\NonMemSportsgroup']->getQuery()->getResult();
    $bssacertlist=$qb['BSSACert']->getQuery()->getResult();
    $sportgrouptrainerlist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    $nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    $sportsgroupnonmemberlist=$qb['Nichtmitglieder\NonMember_Sportsgroup']->getQuery()->getResult();
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
        $sportsgroupdependentlist[$sn->getSgid()]['nonmemberstotal'][$sn->getNmemid()]='Danny';   
    }
    
    foreach ($sportsgroupnonmemberlist as $sm){
    $sportsgroupdependentlist[$sm->getSgid()]['nonmembers'][$sm->getNmemid()]=0;
    }
        
    foreach ($sportsgrouplist as $sg){
        foreach ($nonmemberlist as $nm){               
           
                if(isset($sportsgroupdependentlist[$sg->getSgid()]['nonmembers'][$nm->getNmemid()])){                    
                    if ($nm->getTitle() === 0 ){
                    if(!isset($sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['female']))$sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['female']=0;    
                    {$sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['female']+=1;}
                }else if($nm->getTitle() === 1 ) {
                    if(!isset($sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['male']))$sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['male']=0;    
                    {$sportsgroupdependentlist[$sg->getSgid()]['nonmembers']['male']+=1;}       
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
//**********************************************************************************************************

    /**
     * @Route("/sportgruppen/anlegen/{adminyear}/{letter}", defaults={"letter": "alle", "adminyear": 2016}, name="addsportsgroup", requirements={"letter": "[A-Z]|alle" ,"adminyear": "[1-9][0-9]{3}"})
     * 
     */
     public function addsportsgroupAction (Request $request, $letter, $adminyear){
     
     $doctrine=$this->getDoctrine();   
     $manager= $doctrine->getManager();
     $nonmemsportsgroup = new NonMemSportsgroup();
     $bssacert = new BSSACert();
     $trainer = new Trainer();
     
//     $im=  $this->get('app.index_manager')
//                   ->setEntityName('Sportsgroup');
     
//     $im=new IndexManager($manager, 'Sportsgroup');
     $fm= new FunctionManager($doctrine, $adminyear);
     
//     $sgid=$im->getCurrentIndex();
     $nonmemsportsgroup->setSgid(uniqid('sg'));
     
     $nonmemsportsgroup->addBssacert($bssacert);
     
     $addnonmemsportsgroupform = $this->createForm(BaseSportsgroupType::class, $nonmemsportsgroup, array('adyear' => $adminyear)); 
     $addnonmemsportsgroupform->handleRequest($request);
     
     if($addnonmemsportsgroupform->isSubmitted() && $addnonmemsportsgroupform->isValid()){
        
        $nonmemsportsgroup->setValidfrom($adminyear)
                    ->setValidto('2155');  
        
        $nonmemsportsgroup->setTrainerid($nonmemsportsgroup->getTrainer()->getTrainerid());
        
        foreach($nonmemsportsgroup->getBssacert() as $bs){
                $bs->setBssaid(uniqid('bs'))
           ->setValidfrom($adminyear)
           ->setValidto('2155');       
        $manager->persist($bs);}
//------Generierung der Gruppenbezeichnung-------------------------------        
    switch($day=$nonmemsportsgroup->getDay())
    {
      case ("Montag"):
      $day='mo';
      break;

      case ("Dienstag"):
      $day='di';
      break;
  
      case ("Mittwoch"):
      $day='mi';
      break;
  
      case ("Donnerstag"):
      $day='do';
      break;
  
      case ("Freitag"):
      $day='fr';
      break;
    }
    $time=$nonmemsportsgroup->getTime();
    $m = floor(($time%3600)/60);
    $h = floor(($time%86400)/3600)+1;
    $nonmemsportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$nonmemsportsgroup->getName().'_'.$h.''.$m)));
//------Ende der Generierung der Gruppenbezeichnung-------------------------------        
       
        foreach ($nonmemsportsgroup->getSubstitute() as $su){
                $fm->AddObject($su,'secondary', array('entitypath' => 'AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub','idprefixone' => 'sg','idone' => $nonmemsportsgroup->getSgid()));
            }
            
        $manager->persist($nonmemsportsgroup);     
        $manager->flush();

//        $im->add();
        $this->addFlash('notice', 'Diese Nichtmitglieder-Sportgruppe wurde erfolgreich angelegt');
        return $this->redirectToRoute('sportsgroup_home', array('letter'=>$letter, 'adminyear' => $adminyear));
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
//------------------------------------------------------------------------------------------------- 
     
     
    /**
     * @Route("/sportgruppen/bearbeiten/{adminyear}/{letter}/{ID}", name="editsportsgroup", defaults={"letter": "alle"})
     * 
     */       
     public function editsportsgroupAction(Request $request, $adminyear, $ID, $letter){
     
        $doctrine=$this->getDoctrine(); 
        $manager= $doctrine->getManager();
        $validfrom=$request->query->get('version');
        $fm= new FunctionManager($doctrine, $adminyear);
       
        $dependencies=['BSSACert',  'Nichtmitglieder\Trainer_NonMemSportsgroupSub'];
        $qb=[];
        
        foreach($dependencies as $dependent){
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear)
                    ->andWhere('ditto.sgid=:ID')
                    ->setParameter('ID',$ID)
                   ;
        }



        $nmemsportsgroup=$doctrine->getRepository('AppBundle:Nichtmitglieder\NonMemSportsgroup')->findOneBy(array('sgid'=>(string)$ID, 'validfrom'=>$validfrom));
        $ntid=$nmemsportsgroup->getTrainerid();
        echo $ntid;
        $nmemsportsgrouporiginal= clone $nmemsportsgroup;
        
         if(!$nmemsportsgroup){
            throw $this->createNotFoundException('Es konnte keine Sportgruppe mit der ID.: '.$ID.' gefunden werden');
        }
        $bssacert=$qb['BSSACert']->getQuery()->getResult();
        $trainerlist=$doctrine->getRepository('AppBundle:Nichtmitglieder\NonMemSportsgroup')->findOneBy(array('trainerid'=>$nmemsportsgroup->getTrainerid(), 'validfrom'=>$validfrom));
        $trainersublist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();


        
        $originalbssacerts = new ArrayCollection();
        $originaltrainers = new ArrayCollection();
        $originaltrainersubs = new ArrayCollection();

        
        // Create an ArrayCollection of the current Rehab objects in the database
        foreach ($bssacert as $bssa) {
            $originalbssacert= clone $bssa;
            $nmemsportsgroup->addBssacert($bssa);
            $originalbssacerts->add($originalbssacert);
        }
        
        foreach ($trainerlist as $tr) {
            $originaltrainer= clone $tr;
            $nmemsportsgroup->addTrainer($bssa);
            $originaltrainers->add($originaltrainer);
        }
        
        foreach ($trainersublist as $tsub) {
            $ts=$doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy(array('trainerid' => $tsub->getTrainerid(), 'validfrom'=>$validfrom));

            $originaltrainersub= clone $ts;
            $nmemsportsgroup->addSubstitute($ts);
            $originaltrainersubs->add($originaltrainersub);
        }
    
    
    
        $editsportsgroupform = $this->createForm(EditSportsgroupType::class, $nmemsportsgroup, array('adyear' => $adminyear));
        $editsportsgroupform->handleRequest($request);
        
        if($editsportsgroupform->get('delete')->isClicked()){
            $fm->RemoveObject($nmemsportsgroup,array('BSSACert', 'Nichtmitglieder\Trainer_NonMemSportsgroupSub', 'Nichtmitglieder\NonMember_Sportsgroup'));
            $manager->flush();
            $this->addFlash('notice', 'Diese Nichtmitglieder-Sportgruppe wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter, 'adminyear' => $adminyear));
        }
        
        if($editsportsgroupform->isSubmitted() && $editsportsgroupform->isValid()){
  
            $fm->HandleDependencyDiff($nmemsportsgroup->getBssacert(), $originalbssacerts);
            $fm->HandleDependencyDiff($nmemsportsgroup->getTrainer(), $originaltrainers);
            $fm->HandleDependencyDiff($nmemsportsgroup->getSubstitute(), $originaltrainersubs, array('entitypath' => 'AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub','idprefixone' => 'sg','idone' => $nmemsportsgroup->getSgid()));
            
          

            $fm->HandleObjectDiff($nmemsportsgroup, $nmemsportsgrouporiginal);
           //------Generierung der Gruppenbezeichnung-------------------------------        
            switch($day=$nmemsportsgroup->getDay())
            {
              case ("Montag"):
              $day='mo';
              break;

              case ("Dienstag"):
              $day='di';
              break;

              case ("Mittwoch"):
              $day='mi';
              break;

              case ("Donnerstag"):
              $day='do';
              break;

              case ("Freitag"):
              $day='fr';
              break;
            }
            $time=$nmemsportsgroup->getTime();
            $m = floor(($time%3600)/60);
            $h = floor(($time%86400)/3600)+1;
            $nmemsportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$nmemsportsgroup->getName().'_'.$h.''.$m)));
           
            $manager->flush();
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');           
          return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter, 'adminyear' => $adminyear));  
        }
        
        return $this->render(
        'Sportgruppen/sportsgroupform.html.twig',
        array(
           'form' => $editsportsgroupform->createView(),
           'cletter' => $letter,
           'title' => 'Sportgruppen bearbeiten',
           'adminyear' => $adminyear
           ));
    }
     
}
