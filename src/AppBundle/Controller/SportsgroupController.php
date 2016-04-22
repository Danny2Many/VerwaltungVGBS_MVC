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
    $dependencies=array('Nichtmitglieder\NonMemSportsgroup', 'BSSACert', 'Nichtmitglieder\Nonmember', 'Nichtmitglieder\Trainer_NonMemSportsgroupSub' , 'Trainer\Trainer', 'Nichtmitglieder\NonMember_Sportsgroup');
    $qb=[];
       foreach($dependencies as $dependent){
  
           $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear);   
    } 
//   $entityManager= $this->getDoctrine();
//    $sb = $entityManager->createQueryBuilder();
//    $sb->select('count(account.nmemid)');
//    $sb->from('Appbundle:Nichtmitglieder\Nonmember','account');
//
//$count = $sb->getQuery()->getSingleScalarResult();
//    
$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Nichtmitglieder\Nonmember');
$title =0;
$sb = $repository->createQueryBuilder('t');
$sb->select('count(t.nmemid)');
$sb->where('t.nmemid <=:name');
$sb->setParameter('title', $title);
$nombre = $sb->getQuery()->getSingleScalarResult();


    echo '<pre>';
     print_r($nombre);
     echo '</pre>';
    
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
    $sportgrouptrainerlist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    $nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    $sportsgroupnonmemberlist=$qb['Nichtmitglieder\NonMember_Sportsgroup']->getQuery()->getResult();
    
    $sportsgroupdependentlist=[];
    foreach ($bssacertlist as $bs){
        $sportsgroupdependentlist[$bs->getSgid()]['terminationdate'][]=$bs;  
        $sportsgroupdependentlist[$bs->getSgid()]['startdate'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['validfrom'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['groupnr'][]=$bs; 
        $sportsgroupdependentlist[$bs->getSgid()]['bssacertnr'][]=$bs; 
    }
    
//    foreach ($sportsgroupnonmemberlist as $sn){
//        $sportsgroupdependentlist[$sn->getSgid()]['nonmembers'][$sn->getNmemid()]=$sn->getNmemid();
//    }
//    $t=0;
//    foreach ($sportsgrouplist as $sg){
//           foreach ($nonmemberlist as $nm){
//         $sportsgroupdependentlist[$sg->getSgid()]['nonmembers'][$nm->getNmemid()]=$nm;
//        $t=count($nm->getNmemid());
//    }
//    echo '<pre>';
//     print_r($t);
//     echo '</pre>';
//    
//    }
    foreach ($sportgrouptrainerlist as $pn){

        $sportsgroupdependentlist[$pn->getSgid()]['trainers'][$pn->getTrainerid()]=$pn->getTrainerid();
    }
    
   foreach ($sportsgrouplist as $sg){
           foreach ($trainerlist as $tr){
         $sportsgroupdependentlist[$sg->getSgid()]['trainers'][$tr->getTrainerid()]=$tr;
         
    }
   }
   
   
//     echo '<pre>';
//     print_r($sportsgroupdependentlist);
//     echo '</pre>';
     
     
     
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
