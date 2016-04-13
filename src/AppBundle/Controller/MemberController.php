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
        
        
    //if $adminyear is the current year
     if($adminyear == date('Y')){
     
     $now=date("Y");
     
     }
     //else take the last day of the choosen year
     else{
         $now=$adminyear;
     }
     
     
     
     
     
    $doctrine=$this->getDoctrine();
    $dependencies=array('Member' => 'mem', 'MemPhoneNumber'=> 'pn', 'MemRehabilitationCertificate'=> 'rc');
    
    $qb= [];
    foreach($dependencies as $dependent => $idprefix){
   
        //building the subquery: SELECT max(recorded) FROM % AS dittosub WHERE dittosub.id = ditto.id
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.validfrom'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
                          
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$now 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.validfrom<=:adminyear')
                    ->andWhere('ditto.validto>:adminyear')
                    ->setParameter('adminyear',$now);
    }
    
    $qb['Member']->andWhere($qb['Member']->expr()->isNull('ditto.quitdate'));
                

    
    
    
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

    


    if($searchcol=='terminationdate'){
        $qb['MemRehabilitationCertificate']->andWhere($qb['MemRehabilitationCertificate']->expr()->like('ditto.'.$searchcol,':type'))
            ->setParameter('type','%'.$searchval.'%');

            $rehacelist=$qb['MemRehabilitationCertificate']->getQuery()->getResult();

            if($rehacelist){          
                foreach ($rehacelist as $rc){         
                $idarray[]=$rc->getMemid();     
            }

            $qb['Member']->andWhere($qb['MemRehabilitationCertificate']->expr()->in('ditto.memid', $idarray));
            $qb['MemRehabilitationCertificate']->orWhere($qb['Member']->expr()->in('ditto.memid', $idarray));
        }

        }else{    


    //building the query

    $qb['Member']->andWhere($qb['Member']->expr()->like('ditto.'.$searchcol, ':member'))
                   ->setParameter('member','%'.$searchval.'%');
    
        }
     
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
    
    
    
    //get the builded queries
     $memberlist=$qb['Member']->getQuery()->getResult();
     $phonenumberlist=$qb['MemPhoneNumber']->getQuery()->getResult();
     $rehabcertlist=$qb['MemRehabilitationCertificate']->getQuery()->getResult();
     
     
     if(!$rehabcertlist){  
        $memberlist=$rehabcertlist;            
        }
     
     
     $memberdependentlist=[];
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
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        

        $im=  $this->get('app.index_manager')

                   ->setEntityName('Member');


        $memid=$im->getCurrentIndex();
        $member->setMemid($memid);
    
        
        
                   
        $member->addPhonenumber($phonenumber);               
      
        $addmemform = $this->createForm(AddMemberType::class, $member);
        $addmemform->handleRequest($request);
     
        

        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){


            

        

            
         
            $manager= $this->getDoctrine()->getManager();
            
            
            
            $member->setValidfrom($adminyear)
                    ->setValidto('2155');
            
            foreach($member->getRehabilitationcertificate() as $rc){
              $rc->setRcid(uniqid('rc'))
                 ->setValidfrom($adminyear)
                 ->setValidto('2155');
              $manager->persist($rc);
              
          }
            
            foreach($member->getPhonenumber() as $pn){
              $pn->setPnid(uniqid('pn'))
                 ->setValidfrom($adminyear)
                 ->setValidto('2155');
              $manager->persist($pn);
              
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
    $dependencies=array('Member' => 'mem', 'MemPhoneNumber'=> 'pn', 'MemRehabilitationCertificate'=> 'rc');
    
    $qb=[];
    
    foreach($dependencies as $dependent => $idprefix){
        //building the subquery: SELECT max(recorded) FROM % AS dittosub WHERE dittosub.type = ditto.type 
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.validfrom'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
                          
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$adminyear AND ditto.memid=§ID
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.memid=:ID')
                    ->andWhere('ditto.validfrom<=:adminyear')
                    ->andWhere('ditto.validto>:adminyear')
                    ->setParameter('ID',$ID)
                    ->setParameter('adminyear',$adminyear);
     

        
    }
        
        
        
        
        
        $member=$qb['Member']->getQuery()->getSingleResult();
        
        
        
        if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
        
        $phonenumbers=$qb['MemPhoneNumber']->getQuery()->getResult();
        $rehabcerts=$qb['MemRehabilitationCertificate']->getQuery()->getResult();
        
       
        
         $originalrehabs = new ArrayCollection();
         $originalphonenr = new ArrayCollection();
        

         
         echo '<pre>'; 
        print_r($originalrehabs);
        echo '</pre>';
         
         
         
         
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
            'title' => 'Mitglied bearbeiten',
            'adminyear' => $adminyear
            ));
    }
    
}


