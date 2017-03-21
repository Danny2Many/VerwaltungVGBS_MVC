<?php

// src/AppBundle/Controller/MemberController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Mitglieder\Member;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Mitglieder\AddMemberType;
use AppBundle\Form\Type\Mitglieder\EditMemberType;



use AppBundle\Entity\Mitglieder\MemPhoneNumber;
use Symfony\Component\HttpFoundation\Request;




class MemberController extends Controller
{

    /**
     * @Route("/mitglieder/{letter}", defaults={"letter"="A"}, name="member_home", requirements={"letter": "[A-Z]"})
     */
    public function indexAction(Request $request, $letter)
    {
        
   $doctrine=$this->getDoctrine();
//   $dependencies=array('Member', 'MemPhoneNumber', 'MemRehabilitationCertificate', 'MemSportsgroup', 'Member_Sportsgroup',);
   $dependencies=array('Member', 'MemPhoneNumber', 'MemRehabilitationCertificate');    
    $qb= [];
    foreach($dependencies as $dependent){
 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:Mitglieder\\'.$dependent)->createQueryBuilder('ditto');
                    
       
    }
    
    $qb['Member']->where($qb['Member']->expr()->isNull('ditto.quitdate'));
               


     
    
    
    $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email',
        'Sportgruppe' => 'token',
        'RS-Ablaufdatum' => 'terminationdate',
        'Krankenkasse' => 'healthinsurance');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home')));
    $rehabsearchform = $this->createForm(\AppBundle\Form\Type\RehabcertSearchType::class, null, array('action' => $this->generateUrl('member_home')));
        
    $searchform->handleRequest($request);
    
    
    //the search
    if($searchform->isSubmitted() && $searchform->isValid()){
     
        //setting the letter to null for the pagination not to show any letter
     $letter=null;
     
     //getting the values of the field and column
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];

    


    if($searchcol=='terminationdate'){
        $rehabsearchqb= clone $qb['MemRehabilitationCertificate'];
        $rehabsearchqb->andWhere($rehabsearchqb->expr()->like('ditto.'.$searchcol,':type'))
            ->setParameter('type','%'.$searchval.'%');

            $rehacelist=$rehabsearchqb->getQuery()->getResult();
            

            
                
                if($rehacelist){
                foreach ($rehacelist as $rc){         
                $idarray[]=$rc->getMemid();     
                }
                }else{
                  $idarray=array(null);  
                }

            $qb['Member']->andWhere($qb['Member']->expr()->in('ditto.memid', $idarray));
        }
        
       
        
        else{



    //building the query

    $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.'.$searchcol, ':member'))
                 ->setParameter('member','%'.$searchval.'%');
    
        }
     
    }
    
    else{
      
        
        $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.lastname',':letter' ))
                    ->setParameter('letter',$letter.'%');
                   
           
        
          switch($letter){
            case 'A': $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                                  ->setParameter('umlautletter','Ä%');
            break;
        
            case 'O': $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                                    ->setParameter('umlautletter','Ö%');
            break;
        
            case 'U': $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.lastname', ':umlautletter'))
                                    ->setParameter('umlautletter','Ü%');
            break;
        } 
        
        
    }
    

    
    //get the builded queries
     $memberlist=$qb['Member']->getQuery()->getResult();
     $phonenumberlist=$qb['MemPhoneNumber']->getQuery()->getResult();
     $rehabcertlist=$qb['MemRehabilitationCertificate']->getQuery()->getResult();
//     $sportsgroupmemberlist=$qb['Member_Sportsgroup']->getQuery()->getResult();
//     $sportsgrouplist=$qb['MemSportsgroup']->getQuery()->getResult();
    
     
    
     

     
    $memberdependentlist=[];

     
//    foreach ($sportsgroupmemberlist as $sn){
//
//        $memberdependentlist[$sn->getMemid()]['sportsgroups'][$sn->getSgid()]=0;
//    }
//    
     
    
    
//    foreach ($memberlist as $nm){
//        foreach ($sportsgrouplist as $sg){
//            
//            if(isset($memberdependentlist[$nm->getMemid()]['sportsgroups'][$sg->getSgid()])){
//            $memberdependentlist[$nm->getMemid()]['sportsgroups'][$sg->getSgid()]=$sg;
//            } 
//        }
//    }     
     
     foreach ($phonenumberlist as $pn){
         
         $memberdependentlist[$pn->getMemid()]['phonenumbers'][]=$pn;
     }
     
     
     $now= date('Y-m-d');
      foreach ($rehabcertlist as $rc){
        if($rc->getTerminationdate()->format("Y-m-d") > $now){
         $memberdependentlist[$rc->getMemid()]['validrehabcerts'][]=$rc;
        }else{
          $memberdependentlist[$rc->getMemid()]['expiredrehabcerts'][]=$rc;  
        }
         
     }
     
     
     
     

    return $this->render(
        'Mitglieder/member.html.twig',
        array(
            'tabledata' => $memberlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'rehabsearchform' => $rehabsearchform->createView(),

            'memberdependentlist' => $memberdependentlist,         

            'cletter' => $letter,

            'path' => 'member_home'
           
         
            ));
    }
  
    
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * @Route("/mitglieder/anlegen/{letter}", defaults={"letter": "A"}, name="addmem", requirements={"letter": "[A-Z]"})
     * 
     */
    public function addmemberAction(Request $request, $letter)
    {
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        $m_sg= new \AppBundle\Entity\Mitglieder\Member_Sportsgroup();
  
              
        $member->addPhonenumber($phonenumber);               
        $member->addSportsgroup($m_sg);

        $addmemform = $this->createForm(AddMemberType::class, $member);
        $addmemform->handleRequest($request);
     
    
        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){

            $manager= $this->getDoctrine()->getManager();            
                    

            
//            foreach($member->getRehabilitationcertificate() as $rc){
//                $fm->AddObject($rc, 'secondary');
//              
//          }
//            
//            foreach($member->getPhonenumber() as $pn){
//                $fm->AddObject($pn, 'secondary');
//              
//          }
//          
//           foreach ($member->getSportsgroup() as $sg){
//                $fm->AddObject($sg,'secondary', array('entitypath' => 'AppBundle\Entity\Member_Sportsgroup','idprefixone' => 'mem','idone' => $member->getMemid()));
//            }
//            
             
          
 
                      
          
            
            $manager->persist($member);
            
//            foreach ($member->getPhonenumber() as $pn){
//              $manager->persist($pn);  
//            }
//            foreach ($member->getRehabilitationcertificate() as $rc){
//                $rc->setMemid($member->getMemid());
//              $manager->persist($rc);  
//            }            

            
            $manager->flush();
            
            
//            $im->add();
            
            
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
     * @Route("/mitglieder/bearbeiten/{letter}/{ID}", defaults={"letter": "[A-Z]"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $ID, $letter)
    {
      
        
        
    
    
    $doctrine=$this->getDoctrine(); 
    $manager= $doctrine->getManager();
  

        

     

            $member=$doctrine->getRepository('AppBundle:Mitglieder\Member')->findOneBy(array('memid'=>$ID));
         


    
         
        
        
        if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
   
    
    
        

        

        
         $originalrehabs = new ArrayCollection();
         $originalphonenrs = new ArrayCollection();
         $originalsportsgroups = new ArrayCollection();
        

         
         
         
         
         
         
    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getRehabilitationcertificate() as $rehab) {
 
   
        $originalrehabs->add($rehab);
    }

       // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getPhonenumber() as $pn) {
 
   
        $originalphonenrs->add($pn);
    }
    
           // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getSportsgroup() as $sg) {
 
   
        $originalsportsgroups->add($sg);
    }
    
    
    
      $editmemform = $this->createForm(EditMemberType::class, $member);
        
        
        
    
    
        $editmemform->handleRequest($request);
        
        
        
        if($editmemform->get('delete')->isClicked()){

            $manager->remove($member);
            $manager->flush();

            $this->addFlash('notice', 'Dieses Mitglied wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('member_home', array('letter' => $letter));
        }

        
       
    
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid()){
                
                
              
                foreach ($originalrehabs as $rehab) {
            if (false === $member->getRehabilitationcertificate()->contains($rehab)) {
                $manager->remove($rehab);
            }
        }

                  
        foreach ($originalphonenrs as $pn) {
            if (false === $member->getPhonenumber()->contains($pn)) {
                $manager->remove($pn);
            }
        }                
        
        
        foreach ($originalsportsgroups as $sg) {
            if (false === $member->getSportsgroup()->contains($sg)) {
                $manager->remove($sg);
            }
        }              
                
                
                
                $manager->persist($member);
                $manager->flush();
                
 
                
                
               
      $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');  
      return $this->redirectToRoute('member_home', array('letter' => $letter));  
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


