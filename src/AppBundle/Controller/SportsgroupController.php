<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup;
use AppBundle\Entity\Sportsgroup;
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
    * @Route("/sportgruppen/{letter}", defaults={"letter"="alle"}, name="sportsgroup_home" , requirements={"letter": "Montag|Dienstag|Mittwoch|Donnerstag|Freitag|Samstag|Sonntag|alle"})
    */ 
     public function indexAction (Request $request, $letter){
     
        
    $doctrine = $this->getDoctrine();
    $dependencies=array('Sportsgroup', 'BSSACert', 'Trainer\Trainer', 'Room');
    $qb=[];
       foreach($dependencies as $dependent){
           $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
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

    
    $choices=array('Sportgruppe' => 'name',
                   'Gruppenbez.' => 'token',
                   'Wochentag' => 'day'
        
        );
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('sportsgroup_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
      //building the query
    $qb['Sportsgroup']->andWhere($qb['Sportsgroup']->expr()->like('ditto.'.$searchcol, ':sportsgroup'))

                   ->setParameter('sportsgroup','%'.$searchval.'%')
                   ->getQuery();
    
       
    }
     else if ($letter !='alle')
    {
        $qb['Sportsgroup']->andWhere($qb['Sportsgroup']->expr()->like('ditto.day', ':letter'))
                  ->setParameter('letter',$letter);
    }
    else
    {
     $letter=null; 
    } 
    
    $sportsgrouplist=$qb['Sportsgroup']->getQuery()->getResult();
    $bssacertlist=$qb['BSSACert']->getQuery()->getResult();
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    //$nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    //$sportsgroupnonmemberlist=$qb['Nichtmitglieder\NonMember_Sportsgroup']->getQuery()->getResult();
    $roomlist=$qb['Room']->getQuery()->getResult();
    
    $sportsgroupdependentlist=[];
    foreach ($bssacertlist as $bs){
        $sportsgroupdependentlist[$bs->getSgid()]['terminationdate'][]=$bs;  
        $sportsgroupdependentlist[$bs->getSgid()]['startdate'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['groupnr'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['bssacertnr'][]=$bs; 
    }
     foreach ($roomlist as $ro)
     {
        $sportsgroupdependentlist[$ro->getRoomid()]['room'][]=$ro; 
     }
    
    foreach ($trainerlist as $tr)
        {
         $sportsgroupdependentlist[$tr->getTrainerid()]['trainer'][]=$tr; 
        }
  
//    //Substitute Teacher per Sportsgroup
//    foreach ($sportgrouptrainerlist as $pn){
//        $sportsgroupdependentlist[$pn->getSgid()]['trainersub'][$pn->getTrainerid()]=0;
//    }
    
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
         'tabledata' => $sportsgrouplist, 
         'path' => 'sportsgroup_home'
         ));
}
//**********************************************************************************************************

    /**
     * @Route("/sportgruppen/anlegen/{letter}", defaults={"letter": "alle"}, name="addsportsgroup", requirements={ "letter": "Montag|Dienstag|Mittwoch|Donnerstag|Freitag|Samstag|Sonntag|alle"})
     */
     public function addsportsgroupAction (Request $request, $letter){
     
     $sportsgroup=new Sportsgroup();
     $doctrine=$this->getDoctrine();   
     $manager= $doctrine->getManager();
     $bssacert = new BSSACert();
     $trainer = new Trainer();
     

     $sportsgroup->setSgid(uniqid('sg'));
     $sportsgroup->addBssacert($bssacert);
     
     $addnonmemsportsgroupform = $this->createForm(BaseSportsgroupType::class, $sportsgroup); 
     $addnonmemsportsgroupform->handleRequest($request);
     
     if($addnonmemsportsgroupform->isSubmitted() && $addnonmemsportsgroupform->isValid()){
        $sportsgroup->setTrainerid($sportsgroup->getTrainer()->getTrainerid());
        
        foreach($sportsgroup->getBssacert() as $bs){
                $bs->setBssaid(uniqid('bs'));       
        $manager->persist($bs);}
//------Generierung der Gruppenbezeichnung-------------------------------        
    switch($day=$sportsgroup->getDay())
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
    $time=$sportsgroup->getTime();
    $m = floor(($time%3600)/60);
    $h = floor(($time%86400)/3600)+1;
    $sportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$sportsgroup->getName().'_'.$h.''.$m)));
//------Ende der Generierung der Gruppenbezeichnung-------------------------------        
       
        $manager->persist($sportsgroup);     
        $manager->flush();

        $this->addFlash('notice', 'Diese Sportgruppe wurde erfolgreich angelegt');
        return $this->redirectToRoute('sportsgroup_home', array('letter'=>$letter));
     }
     
    return $this->render(
      'Sportgruppen/sportsgroupform.html.twig',
      array(            
          'form' => $addnonmemsportsgroupform->createView(),
          'cletter' => $letter,
          'title' => 'Sportgruppe anlegen',
          ));
     }
//------------------------------------------------------------------------------------------------- 
     
    /**
     * @Route("/sportgruppen/bearbeiten/{letter}/{ID}", name="editsportsgroup", defaults={"letter": "alle"})
     */       
     public function editsportsgroupAction(Request $request, $ID, $letter){
     
        $doctrine=$this->getDoctrine(); 
        $manager= $doctrine->getManager();
        
        $sportsgroup=$doctrine->getRepository('AppBundle:Sportsgroup')->findOneBy(array('sgid'=>(string)$ID));
      
         if(!$sportsgroup)
         {
            throw $this->createNotFoundException('Es konnte keine Sportgruppe mit der ID.: '.$ID.' gefunden werden');
         }
        
        $originalbssacerts = new ArrayCollection();
        $originaltrainers = new ArrayCollection();
        $originaltrainersubs = new ArrayCollection();
        
        
        foreach($sportsgroup->getBssacert() as $bssa)
            {
             $originalbssacerts->add($bssa);
            }
       
        foreach($sportsgroup->getTrainer()as $trainer)
            {
             $originaltrainers->add($trainer);
            }
            
        $editsportsgroupform = $this->createForm(EditSportsgroupType::class, $sportsgroup);
        $editsportsgroupform->handleRequest($request);
        
        if($editsportsgroupform->get('delete')->isClicked()){
            $manager->remove($sportsgroup);
            $manager->flush();
            $this->addFlash('notice', 'Diese Sportgruppe wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter));
        }
        
       if($editsportsgroupform->isSubmitted() && $editsportsgroupform->isValid())
       {
        foreach($originalbssacerts as $obss )
        {
         if($sportsgroup->getBSSACert()->contains($obss)==false)
         {
          $manager->remove($obss);
         }     
        }
        
        foreach($originaltrainers as $otr )
        {
         if($sportsgroup->getTrainer()->contains($otr)==false)
         {
          $manager->remove($otr);
         }     
        }
        
        switch($day=$sportsgroup->getDay())
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
            $time=$sportsgroup->getTime();
            $m = floor(($time%3600)/60);
            $h = floor(($time%86400)/3600)+1;
            $sportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$sportsgroup->getName().'_'.$h.''.$m)));
            $manager->flush();
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');           
          return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter)); 
        } 
        
        return $this->render('Sportgruppen/sportsgroupform.html.twig',
                       array(
                             'form' => $editsportsgroupform->createView(),
                             'cletter' => $letter,
                             'title' => 'Sportgruppen bearbeiten',)
                            );
        
//--------------------------------------------------------------------------------------------------------------
//        $dependencies=['BSSACert',  'Nichtmitglieder\Trainer_NonMemSportsgroupSub'];
//        $qb=[];
//        foreach($dependencies as $dependent){
//            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
//            $qb[$dependent]->andWhere('ditto.sgid=:ID')
//                    ->setParameter('ID',$ID);
//        }
//
//      
//        $sportsgrouporiginal= clone $sportsgroup;
//        
//        $bssacert=$qb['BSSACert']->getQuery()->getResult();
//        $trainerlist=$doctrine->getRepository('AppBundle:Sportsgroup')->findOneBy(array('trainerid'=>$sportsgroup->getTrainerid()));
//        $trainersublist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();
//
//
//        // Create an ArrayCollection of the current Rehab objects in the database
//        foreach ($bssacert as $bssa) {
//            $originalbssacert= clone $bssa;
//            $sportsgroup->addBssacert($bssa);
//            $originalbssacerts->add($originalbssacert);
//        }
//        
//        foreach ($trainerlist as $tr) {
//            $originaltrainer= clone $tr;
//            $sportsgroup->addTrainer($tr);
//            $originaltrainers->add($originaltrainer);
//        }
//        
//        foreach ($trainersublist as $tsub) {
//            $ts=$doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy(array('trainerid' => $tsub->getTrainerid()));
//
//            $originaltrainersub= clone $ts;
//            $sportsgroup->addSubstitute($ts);
//            $originaltrainersubs->add($originaltrainersub);
//        }
//    
//    
//    
//        $editsportsgroupform = $this->createForm(EditSportsgroupType::class, $nmemsportsgroup);
//        $editsportsgroupform->handleRequest($request);
//        
//        if($editsportsgroupform->get('delete')->isClicked()){
///           $manager->remove($sportsgroup);
//            $manager->flush();
///           $this->addFlash('notice', 'Diese Sportgruppe wurde erfolgreich gelöscht!');
///           return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter));
//        }
//        
//        if($editsportsgroupform->isSubmitted() && $editsportsgroupform->isValid()){
//            $fm->HandleDependencyDiff($nmemsportsgroup->getBssacert(), $originalbssacerts);
//            $fm->HandleDependencyDiff($nmemsportsgroup->getTrainer(), $originaltrainers);
//            $fm->HandleDependencyDiff($nmemsportsgroup->getSubstitute(), $originaltrainersubs, array('entitypath' => 'AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub','idprefixone' => 'sg','idone' => $nmemsportsgroup->getSgid()));
//            
//          $nmemsportsgroup->setTrainerid($nmemsportsgroup->getTrainer()->getTrainerid());
//
//            $fm->HandleObjectDiff($nmemsportsgroup, $nmemsportsgrouporiginal);
//           //------Generierung der Gruppenbezeichnung-------------------------------        
//            switch($day=$nmemsportsgroup->getDay())
//            {
//              case ("Montag"):
//              $day='mo';
//              break;
//
//              case ("Dienstag"):
//              $day='di';
//              break;
//
//              case ("Mittwoch"):
//              $day='mi';
//              break;
//
//              case ("Donnerstag"):
//              $day='do';
//              break;
//
//              case ("Freitag"):
//              $day='fr';
//              break;
//            }
//            $time=$nmemsportsgroup->getTime();
//            $m = floor(($time%3600)/60);
//            $h = floor(($time%86400)/3600)+1;
//            $nmemsportsgroup->setToken(str_replace(' ', '_',strtolower($day.'_'.$nmemsportsgroup->getName().'_'.$h.''.$m)));
//            //------Ende der Generierung der Gruppenbezeichnung-------------------------------  
//            $manager->flush();
//            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');           
//          return $this->redirectToRoute('sportsgroup_home', array('letter' => $letter));  
//        }
//        
//        return $this->render(
//        'Sportgruppen/sportsgroupform.html.twig',
//        array(
//           'form' => $editsportsgroupform->createView(),
//           'cletter' => $letter,
//           'title' => 'Sportgruppen bearbeiten',
//           
//           ));
    }
     
}
