<?php

// src/AppBundle/Controller/MemberController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Member;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Member\AddMemberType;

use AppBundle\Form\Type\Member\EditMemberType;
use AppBundle\Entity\MemPhoneNumber;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\MemYearInfo;
use AppBundle\Entity\MemMonthlyDues;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;

class MemberController extends Controller
{
    /**
     * @Route("/mitglieder/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="member_home", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})
     */
    public function indexAction(Request $request, $letter, $adminyear)
    {
    
    $doctrine=$this->getDoctrine();
    $dependencies=['Member', 'MemPhoneNumber', 'MemRehabilitationCertificate'];
    
    $qb= [];
    foreach($dependencies as $dependent){
     
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->select(array('ditto', $qb[$dependent]->expr()->max('ditto.recorded')))
                ->where('ditto.recorded <= :year')
                ->groupBy('ditto.memid')
                ->setParameter('year', $adminyear.'-12-31');
     
    }
    
    $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email',
        'Sportgruppe' => 'token',
        'RS-Ablaufd.' => 'terminationdate',
        'Krankenkasse' => 'healthinsurance');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home')));
    
        
    $searchform->handleRequest($request);
    
    
    //the search
    if($searchform->isSubmitted() && $searchform->isValid()){
     
        //setting the letter to null for the pagination not to show any letter
     $letter=null;
     
     //getting the values of the field and column
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
    
    
    //building the query
    $qb['Member']->where($qb['Member']->expr()->like('ditto.'.$searchcol, ':member'))

                   ->setParameter('member','%'.$searchval.'%')
                   ->getQuery();
     
    
       
    
     
     
    }else{
        
        
        $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
                   
        
        
          switch($letter){
            case 'A': $qb['Member']->orWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb['Member']->orWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb['Member']->orWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }
        
       
        
        
        
    }
    
    
    
    
     $memberlist=$qb['Member']->getQuery()->getResult();
     $phonenumberlist=$qb['MemPhoneNumber']->getQuery()->getResult();
     $rehabcertlist=$qb['MemRehabilitationCertificate']->getQuery()->getResult();
     
     
     $memberdependentlist=[];
     foreach ($phonenumberlist as $pn){
         
         $memberdependentlist[$pn[0]->getMemid()]['phonenumbers'][]=$pn;
     }
     
     
      foreach ($rehabcertlist as $rc){
        
         $memberdependentlist[$rc[0]->getMemid()]['rehabcerts'][]=$rc;
         
     }
     
     
     
     

    return $this->render(
        'Mitglieder/member.html.twig',
        array(
            'tabledata' => $memberlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),

            'memberdependentlist' => $memberdependentlist,         

            'cletter' => $letter,
            'adminyear' => $adminyear,
            'path' => 'member_home'
           
         
            ));
    }
  
    
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * @Route("/mitglieder/anlegen/{adminyear}/{letter}", defaults={"letter": "A", "adminyear": 2016}, name="addmem", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})
     * 
     */
    public function addmemberAction(Request $request, $letter, $adminyear)
    {
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        
        
       
            
        $member->addPhonenumber($phonenumber);
               
      
        $addmemform = $this->createForm(AddMemberType::class, $member);
        
        
     
        $addmemform->handleRequest($request);
        
        

        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){

            
            $memid=uniqid('m'); 
            $member->setMemid($memid);

            
         
            $manager= $this->getDoctrine()->getManager();
            

            
            foreach($member->getPhonenumber() as $pn){
              $pn->setPnid(uniqid('pn'));
              $manager->persist($pn);
              
          }
            
             foreach($member->getRehabilitationcertificate() as $rc){
              $rc->setRcid(uniqid('rc'));
              $manager->persist($rc);
              
          }
          
          
          

          $manager->persist($member);
          
            $manager->flush();
            
           $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!'); 
          return $this->redirectToRoute('member_home', array('letter' => $letter));
          
          

        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $addmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied anlegen'
            
            ));
    }
    
    
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 
    
    /**
     * @Route("/mitglieder/bearbeiten/{adminyear}/{letter}/{ID}", defaults={"letter": "[A-Z]"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $adminyear, $ID, $letter)
    {
      
    
    
    
    $doctrine=$this->getDoctrine();   
    $dependencies=array('Member' => 'mem', 'MemPhoneNumber'=> 'pn', 'MemRehabilitationCertificate'=> 'rc');
    
    $qb=[];
    foreach($dependencies as $dependent => $idprefix){
            
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->select(array('ditto', $qb[$dependent]->expr()->max('ditto.recorded')))
                ->where('ditto.recorded <= :year')
                ->andWhere('ditto.memid = :memid')
                ->groupBy('ditto.'.$idprefix.'id')
                ->setParameter('year', $adminyear.'-12-31')
                ->setParameter('memid', $ID);
     
    }
        
        
        
        
        $manager= $doctrine->getManager();
        $member=$qb['Member']->getQuery()->getSingleResult()[0];
        
        
        
        if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
        
        $phonenumbers=$qb['MemPhoneNumber']->getQuery()->getResult()[0][0];
        $rehabcerts=$qb['MemRehabilitationCertificate']->getQuery()->getResult()[0];
        
       
         $originalrehabs = new ArrayCollection();
         $originalphonenr = new ArrayCollection();
         $originalsections = new ArrayCollection();

    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($rehabcerts as $rehab) {
        
        $member->addRehabilitationcertificate($rehab);
        $originalrehabs->add($rehab);
    }
     
    // Create an ArrayCollection of the current Phonenr objects in the database
    foreach ($phonenumbers as $phonenr) {
        $member->addPhonenumber($phonenr);
        $originalphonenr->add($phonenr);
    }
    
    
//     // Create an ArrayCollection of the current Rehab objects in the database
//    foreach ($member->getSection() as $section) {
//        
//        $originalsections->add($section);
//    }
      
        $editmemform = $this->createForm(EditMemberType::class, $member);
        
        

    
    
        $editmemform->handleRequest($request);
        
        
        if($editmemform->get('delete')->isClicked()){

            $manager->remove($member);
            $manager->flush();
            return $this->redirectToRoute('member_home', array('letter' => $letter, 'info' => 'entfernt'));
        }

        
       
    
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid()){
       
      if(!$member->getSportsgroup()->isEmpty()){      
            
            
    foreach ($member->getSportsgroup() as $sportsgroup) {
        
        foreach ($originalsections as $section) {
            
            if (false === $sportsgroup->getSection()->contains($section)) {
                

                $member->removeSection($section);
                
            }
        }
    }
    
    
    foreach($member->getSportsgroup() as $sportsgroup){
                
                foreach($sportsgroup->getSection() as $section){
                
                $member->addSection($section);
            }
            }
            
            
      }else{
          
          $member->getSection()->clear();
      }
     
            
            
            
            
            
            
            
  
          foreach ($originalrehabs as $rehab) {
            if (false === $member->getRehabilitationcertificate()->contains($rehab)) {
                

                $manager->remove($rehab);

            }
        }
            
            foreach ($originalphonenr as $phonenr) {
            if (false === $member->getPhonenumber()->contains($phonenr)) {
                

                $manager->remove($phonenr);

            }
        }
           
  
           
    
    
            $manager->persist($member);
          
            $manager->flush();
            
            
          return $this->redirectToRoute('member_home', array('letter' => $letter, 'info' => 'gespeichert'));  
        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $editmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied bearbeiten'
            ));
    }
    
}


