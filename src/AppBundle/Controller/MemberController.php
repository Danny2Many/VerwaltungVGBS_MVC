<?php

// src/AppBundle/Controller/MemberController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Member;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Member\AddMemberType;
use AppBundle\Form\Type\Member\BaseMemberType;


use AppBundle\Form\Type\Member\EditMemberType;
use AppBundle\Entity\MemPhoneNumber;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\MemYearInfo;
use AppBundle\Entity\MemMonthlyDues;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use AppBundle\Services\FunctionManager;
use AppBundle\Services\IndexManager;



class MemberController extends Controller
{

    /**
     * @Route("/mitglieder/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="member_home", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})
     */
    public function indexAction(Request $request, $letter, $adminyear)
    {
        
   $doctrine=$this->getDoctrine();
   $manager=$doctrine->getManager();
//   $im= new IndexManager($manager, 'Member');
   
   
//   function generateRandomString($length = 10) {
//    $characters = 'abcdefghijklmnopqrstuvwxyz';
//    $charactersLength = strlen($characters);
//    $randomString = '';
//    for ($i = 0; $i < $length; $i++) {
//        $randomString .= $characters[rand(0, $charactersLength - 1)];
//    }
//    return $randomString;
//}
//   
//   for($i=1;$i<=100;$i++){
//       $smember= new Member();
//       $smember->setMemid($im->getCurrentIndex());
//       $smember->setTitle(1);
//       $smember->setPostcode(39108);
//       $smember->setFirstname('Danny');
//       $smember->setLastname(generateRandomString(6));
//       $smember->setLocation('Magdeburg');
//       $smember->setStreetaddress('Peerstreet,69');
//       $smember->setBirthday(new \DateTime('1992-01-07'));
//       $smember->setAdmissiondate(new \DateTime('2016-05-12'));
//       $smember->setState(1);
//       $smember->setDecreaseddues(0);
//       $smember->setNewsletter(array(0));
//       $smember->setAdmissioncharge(69);
//       $smember->setValidfrom(2011);
//       $smember->setValidto(2155);
//       $im->add();
//       $manager->persist($smember);
//   }
//   
//   $manager->flush();
    $dependencies=array('Member', 'MemPhoneNumber', 'MemRehabilitationCertificate', 'MemSportsgroup', 'Member_Sportsgroup',);
    
    $qb= [];
    foreach($dependencies as $dependent){
 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom<=:adminyear')
                    ->andWhere('ditto.validto>:adminyear')
                    ->setParameter('adminyear', $adminyear);                     
       
    }
    
//    $qb['Member']->andWhere($qb['Member']->expr()->isNull('ditto.quitdate'));
               


     
    
    
    $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email',
        'Sportgruppe' => 'token',
        'RS-Ablaufdatum' => 'terminationdate',
        'Krankenkasse' => 'healthinsurance');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home',array('adminyear' => $adminyear))));
    
        
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
     $sportsgroupmemberlist=$qb['Member_Sportsgroup']->getQuery()->getResult();
     $sportsgrouplist=$qb['MemSportsgroup']->getQuery()->getResult();
    
    
     
     if($adminyear == date('Y')){
         $now=date('Y-m-d');
     }
     else{
         $now=$adminyear.'-12-31';
     }
     
    $memberdependentlist=[];

     
    foreach ($sportsgroupmemberlist as $sn){

        $memberdependentlist[$sn->getMemid()]['sportsgroups'][$sn->getSgid()]=$sn->getSgid();
    }
    
    foreach ($memberlist as $nm){
        foreach ($sportsgrouplist as $sg){
            if(isset($memberdependentlist[$nm->getMemid()]['sportsgroups'][$sg->getSgid()])){
            $memberdependentlist[$nm->getMemid()]['sportsgroups'][$sg->getSgid()]=$sg;
            } 
        }
    }     
     
     foreach ($phonenumberlist as $pn){
         
         $memberdependentlist[$pn->getMemid()]['phonenumbers'][]=$pn;
     }
     
     
     
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
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        

//        $im=  $this->get('app.index_manager')
//
//                   ->setEntityName('Member');
        $im= new IndexManager($manager, 'Member');
        $fm= new FunctionManager($doctrine, $adminyear);


        $memid=$im->getCurrentIndex();
        $member->setMemid($memid);
    
        
        
                   
        $member->addPhonenumber($phonenumber);               
      
        $addmemform = $this->createForm(AddMemberType::class, $member, array('adyear' => $adminyear));
        $addmemform->handleRequest($request);
     
        

        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){

            $manager= $this->getDoctrine()->getManager();            
                    
            $member->setValidfrom($adminyear)
                    ->setValidto('2155');
            
            foreach($member->getRehabilitationcertificate() as $rc){
                $fm->AddObject($rc, 'secondary');
              
          }
            
            foreach($member->getPhonenumber() as $pn){
                $fm->AddObject($pn, 'secondary');
              
          }
          
           foreach ($member->getSportsgroup() as $sg){
                $fm->AddObject($sg,'secondary', array('entitypath' => 'AppBundle\Entity\Member_Sportsgroup','idprefixone' => 'mem','idone' => $member->getMemid()));
            }
            
             
          
          
          

            $manager->persist($member);
          
            $manager->flush();
            
            
            $im->add();
            
            
           $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!'); 
          return $this->redirectToRoute('member_home', array('letter' => $letter, 'adminyear' => $adminyear));
          
          

        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $addmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied anlegen',
            'adminyear' => $adminyear
            
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
    $manager= $doctrine->getManager();
    $validfrom=$request->query->get('version');
    $fm= new FunctionManager($doctrine, $adminyear);

        
    $dependencies=['MemPhoneNumber', 'MemRehabilitationCertificate', 'Member_Sportsgroup', ];
    
    $qb=[];
    foreach($dependencies as $dependent){
       
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear)
                    ->andWhere('ditto.memid='.$ID);
    }
    
     

            $member=$doctrine->getRepository('AppBundle:Member')->findOneBy(array('memid'=>$ID, 'validfrom'=>$validfrom));
         
            $memberoriginal= clone $member;

    
         
        
        
        if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
   
    
    
        
        
        $phonenumbers=$qb['MemPhoneNumber']->getQuery()->getResult();
        $rehabcerts=$qb['MemRehabilitationCertificate']->getQuery()->getResult();
        $sportsgrouplist=$qb['Member_Sportsgroup']->getQuery()->getResult();
        

        
         $originalrehabs = new ArrayCollection();
         $originalphonenrs = new ArrayCollection();
         $originalsportsgroups = new ArrayCollection();
        

         
         
         
         
         
         
    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($rehabcerts as $rehab) {
        $originalrehab= clone $rehab;
        $member->addRehabilitationcertificate($rehab);
        $originalrehabs->add($originalrehab);
    }
     
    // Create an ArrayCollection of the current Phonenr objects in the database
    foreach ($phonenumbers as $phonenr) {
        
        $originalphonenr= clone $phonenr;
        $member->addPhonenumber($phonenr);
        $originalphonenrs->add($originalphonenr);
    }
    
    foreach ($sportsgrouplist as $sport) {
             $sp=$doctrine->getRepository('AppBundle:MemSportsgroup')->findOneBy(array('sgid' => $sport->getSgid(), 'validfrom'=>$validfrom));
             
             $originalsportsgroup= clone $sp;          
             $member->addSportsgroup($sp);
             $originalsportsgroups->add($originalsportsgroup);
         }
    
    
      $editmemform = $this->createForm(EditMemberType::class, $member, array('adyear' => $adminyear));
        
        
        
    
    
        $editmemform->handleRequest($request);
        
        
        if($editmemform->get('delete')->isClicked()){

            $fm->RemoveObject($member,array('MemPhoneNumber', 'MemRehabilitationCertificate'));;
            $manager->flush();
            $this->addFlash('notice', 'Dieses Mitglied wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('member_home', array('letter' => $letter, 'adminyear' => $adminyear));
        }

        
       
    
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid()){
       
                $fm->HandleDependencyDiff($member->getRehabilitationcertificate(), $originalrehabs);
                $fm->HandleDependencyDiff($member->getPhonenumber(), $originalphonenrs);
                $fm->HandleDependencyDiff($member->getSportsgroup(), $originalsportsgroups, array('entitypath' => 'AppBundle\Entity\Member_Sportsgroup','idprefixone' => 'mem','idone' => $member->getMemid()));
                
                
                $fm->HandleObjectDiff($member, $memberoriginal);

                $manager->flush();
    
      $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');   
          return $this->redirectToRoute('member_home', array('letter' => $letter, 'adminyear' => $adminyear));  
        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $editmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied bearbeiten',
            'adminyear' => $adminyear
            ));
    }
    
}


