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
use AppBundle\Form\Type\Sportsgroup\EditSportsgroupType;
use AppBundle\Form\Type\Sportsgroup\BaseSportsgroupType;
use AppBundle\Services\IndexManager;
use AppBundle\Services\FunctionManager;


class MemSportsgroupController extends Controller {

    /**
    * @Route("/mitgliedersportgruppen/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016}, name="memsportsgroup_home" , requirements={"letter": "Montag|Dienstag|Mittwoch|Donnerstag|Freitag|Samstag|Sonntag|alle", "adminyear": "[1-9][0-9]{3}"})
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
        $sportsgroupdependentlist[$sn->getSgid()]['memberstotal'][$sn->getMemid()]='Danny';   
    }
    
    foreach ($sportsgroupnonmemberlist as $sm){
    $sportsgroupdependentlist[$sm->getSgid()]['members'][$sm->getMemid()]=0;
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
     * @Route("/mitgliedersportgruppen/anlegen/{adminyear}/{letter}", defaults={"letter": "alle", "adminyear": 2016}, name="addmemsportsgroup", requirements={"letter": "Montag|Dienstag|Mittwoch|Donnerstag|Freitag|Samstag|Sonntag|alle" ,"adminyear": "[1-9][0-9]{3}"})
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
        //------Generierung der Gruppenbezeichnung-------------------------------        
        switch($day=$memsportsgroup->getDay())
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
        $time=$memsportsgroup->getTime();
        $m = floor(($time%3600)/60);
        $h = floor(($time%86400)/3600)+1;
        $memsportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$memsportsgroup->getName().'_'.$h.''.$m)));
         //------Ende der Generierung der Gruppenbezeichnung-------------------------------   
        
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
  
//------------------------------------------------------------------------------------------------- 
     
     
    /**
     * @Route("/mitgliedersportgruppen/bearbeiten/{adminyear}/{letter}/{ID}", name="editmemsportsgroup", defaults={"letter": "alle"})
     * 
     */       
     public function editsportsgroupAction(Request $request, $adminyear, $ID, $letter){
     
        $doctrine=$this->getDoctrine(); 
        $manager= $doctrine->getManager();
        $validfrom=$request->query->get('version');
        $fm= new FunctionManager($doctrine, $adminyear);
       
        $dependencies=['BSSACert',  'Trainer_MemSportsgroupSub'];
        $qb=[];
        
        foreach($dependencies as $dependent){
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear)
                    ->andWhere('ditto.sgid=:ID')
                    ->setParameter('ID',$ID)
                   ;
        }



        $memsportsgroup=$doctrine->getRepository('AppBundle:MemSportsgroup')->findOneBy(array('sgid'=>(string)$ID, 'validfrom'=>$validfrom));
//        print_r($memsportsgroup);
        
        $qb['Trainer\Trainer'] = $doctrine->getRepository('AppBundle:Trainer\Trainer')->createQueryBuilder('ditto');
        $qb['Trainer\Trainer']->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear)
                    ->andWhere('ditto.trainerid=:ID')
                    ->setParameter('ID',$memsportsgroup->getTrainerid())
                ;

        $memsportsgrouporiginal= clone $memsportsgroup;
         if(!$memsportsgroup){
            throw $this->createNotFoundException('Es konnte keine Sportgruppe mit der ID.: '.$ID.' gefunden werden');
        }
        $bssacert=$qb['BSSACert']->getQuery()->getResult();
        $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
        $trainersublist=$qb['Trainer_MemSportsgroupSub']->getQuery()->getResult();

        
        $originalbssacerts = new ArrayCollection();
        $originaltrainers = new ArrayCollection();
        $originaltrainersubs = new ArrayCollection();

        
        // Create an ArrayCollection of the current Rehab objects in the database
        foreach ($bssacert as $bssa) {
            $originalbssacert= clone $bssa;
            $memsportsgroup->addBssacert($bssa);
            $originalbssacerts->add($originalbssacert);
        }
        
        foreach ($trainerlist as $tr) {
            $originaltrainer= clone $tr;
            $memsportsgroup->setTrainer($tr);
            $originaltrainers->add($originaltrainer);
        }
        
        foreach ($trainersublist as $tsub) {
            $ts=$doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy(array('trainerid' => $tsub->getTrainerid(), 'validfrom'=>$validfrom));

            $originaltrainersub= clone $ts;
            $memsportsgroup->addSubstitute($ts);
            $originaltrainersubs->add($originaltrainersub);
        }
    
    
    
        $editsportsgroupform = $this->createForm(EditSportsgroupType::class, $memsportsgroup, array('adyear' => $adminyear));
        $editsportsgroupform->handleRequest($request);
        
        if($editsportsgroupform->get('delete')->isClicked()){
            $fm->RemoveObject($memsportsgroup,array('BSSACert', 'Trainer_MemSportsgroupSub', 'Member_Sportsgroup'));
            $manager->flush();
            $this->addFlash('notice', 'Diese Nichtmitglieder-Sportgruppe wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('memsportsgroup_home', array('letter' => $letter, 'adminyear' => $adminyear));
        }
        
        if($editsportsgroupform->isSubmitted() && $editsportsgroupform->isValid()){
  
            $fm->HandleDependencyDiff($memsportsgroup->getBssacert(), $originalbssacerts);
//            $fm->HandleDependencyDiff($memsportsgroup->getTrainer(), $originaltrainers);
            $fm->HandleDependencyDiff($memsportsgroup->getSubstitute(), $originaltrainersubs, array('entitypath' => 'AppBundle\Entity\Trainer_MemSportsgroupSub','idprefixone' => 'sg','idone' => $memsportsgroup->getSgid()));
                    
            $memsportsgroup->setTrainerid($memsportsgroup->getTrainer()->getTrainerid());

            
            $fm->HandleObjectDiff($memsportsgroup, $memsportsgrouporiginal);
            
            $manager->flush();
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');           
          return $this->redirectToRoute('memsportsgroup_home', array('letter' => $letter, 'adminyear' => $adminyear));  
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
