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
   
    $dependencies=array('Member', 'MemPhoneNumber', 'MemRehabilitationCertificate');
    
    $qb= [];
    foreach($dependencies as $dependent){
 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom<=:adminyear')
                    ->andWhere('ditto.validto>:adminyear')
                    ->setParameter('adminyear', $adminyear);                     
       
    }
    
//    $qb['Member']->andWhere($qb['Member']->expr()->isNull('ditto.quitdate'));
               

//        echo '<pre>';
//            print_r($qb['MemPhoneNumber']->getQuery()->getResult());
//            echo '</pre>';
     
    
    
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
     
    
     
     if($adminyear == date('Y')){
         $now=date('Y-m-d');
     }
     else{
         $now=$adminyear.'-12-31';
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
        $manager= $this->getDoctrine()->getManager();
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        

//        $im=  $this->get('app.index_manager')
//
//                   ->setEntityName('Member');
        $im= new IndexManager($manager, 'Member');
        

        $memid=$im->getCurrentIndex();
        $member->setMemid($memid);
    
        
        
                   
        $member->addPhonenumber($phonenumber);               
      
        $addmemform = $this->createForm(AddMemberType::class, $member);
        $addmemform->handleRequest($request);
     
        

        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){


            

        

            
         
            
            
            
            
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
    $validfrom=$request->query->get('version');
    $fm= new FunctionManager($doctrine, $adminyear);

        
    $dependencies=['MemPhoneNumber', 'MemRehabilitationCertificate'];
    
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
        

        
         $originalrehabs = new ArrayCollection();
         $originalphonenrs = new ArrayCollection();
        

         
         
         
         
         
         
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
    
    
      $editmemform = $this->createForm(EditMemberType::class, $member);
        
        
        
    
    
        $editmemform->handleRequest($request);
        
        
        if($editmemform->get('delete')->isClicked()){

            $fm->RemoveObject($member,array($member->getRehabilitationcertificate(),$member->getPhonenumber()));;
            $manager->flush();
            $this->addFlash('notice', 'Dieses Mitglied wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('member_home', array('letter' => $letter, 'adminyear' => $adminyear));
        }

        
       
    
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid()){
       
                $fm->HandleDependencyDiff($member->getRehabilitationcertificate(), $originalrehabs, $adminyear);
                $fm->HandleDependencyDiff($member->getPhonenumber(), $originalphonenrs, $adminyear);
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


