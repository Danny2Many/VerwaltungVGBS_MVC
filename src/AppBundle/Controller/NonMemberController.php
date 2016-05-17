<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\Nonmember;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Nichtmitglieder\AddNonMemberType;
use AppBundle\Form\Type\Nichtmitglieder\BaseNonMemberType;

use AppBundle\Form\Type\Nichtmitglieder\EditNonMemberType;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\FormBuilder;
use AppBundle\Entity\Section;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;

use AppBundle\Services\FunctionManager;
use AppBundle\Services\IndexManager;

class NonMemberController extends Controller {
    /**
     * @Route("/nichtmitglieder/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="nonmember_home", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})

    */    
    public function indexAction (Request $request, $letter, $adminyear ) {   

     
    $doctrine = $this->getDoctrine();
    $dependencies=['Nichtmitglieder\Nonmember', 'Nichtmitglieder\NonMemPhoneNumber', 'Nichtmitglieder\NonMemSportsgroup','Nichtmitglieder\NonMemRehabilitationCertificate', 'Nichtmitglieder\NonMember_Sportsgroup'];
    $qb=[];
      foreach($dependencies as $dependent){
   
       
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                    ->andWhere('ditto.validto>'.$adminyear);
//                    ->setParameter('adminyear', $adminyear);
    }
        

    
    $choices=array('Nichtmitgliedsnr.' => 'nmemid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Straße' => 'streetaddress',
        'E-Mail' => 'email',
        'Sportgruppe' => 'token',
        'RS-Ablaufdatum' => 'terminationdate',
        'Krankenkasse' => 'healthinsurance');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('nonmember_home',array('adminyear' => $adminyear))));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
        //setting the letter to null for the pagination not to show any letter
        $letter=null;   
        //getting the values of the field and column
        $searchval=$request->query->get('search')['searchfield'];
        $searchcol=$request->query->get('search')['column'];
    
    if($searchcol=='terminationdate'){
        //$rehabsearchqb= clone $qb['MemRehabilitationCertificate'];
       // $rehabsearchqb->andWhere($rehabsearchqb->epxr()->like('ditto.'.$searchcol,':type'))
        $qb['Nichtmitglieder\NonMemRehabilitationCertificate']->andWhere($qb['Nichtmitglieder\NonMemRehabilitationCertificate']->expr()->in('ditto.'.$searchcol,':type'))
        ->setParameter('type','%'.$searchval.'%');

            $rehacelist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();


            
            if($rehacelist){          
                foreach ($rehacelist as $rc){         
                $idarray[]=$rc->getNmemid();     
                }
            }
            $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->in('ditto.nmemid', $idarray));
            
            }
//            else{
//                $qb['Nichtmitgleider\Nonmember']->andWhere('ditto.nmemid<=:abort')->setParameter('abort',-1);
//            }
            else{
            $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.'.$searchcol, ':nonmember'))
               ->setParameter('nonmember','%'.$searchval.'%');
    } 
        
    }else{        
        
        $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');                
        
        
          switch($letter){
            case 'A': $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }    
    }    
    //get the builded queries
    $nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    $phonenumberlist=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
    $rehabcertlist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
    $sportsgroupnonmemberlist=$qb['Nichtmitglieder\NonMember_Sportsgroup']->getQuery()->getResult();
    $sportsgrouplist=$qb['Nichtmitglieder\NonMemSportsgroup']->getQuery()->getResult();
    if($adminyear == date('Y')){
         $now=date('Y-m-d');
     }
     else{
         $now=$adminyear.'-12-31';
     }
     $nonmemberdependentlist=[];
     
    foreach ($sportsgroupnonmemberlist as $sn){

        $nonmemberdependentlist[$sn->getNMemID()]['sportsgroups'][$sn->getSgid()]=$sn->getSgid();
    }
    
    foreach ($nonmemberlist as $nm){
        foreach ($sportsgrouplist as $sg){
            if(isset($nonmemberdependentlist[$nm->getNmemid()]['sportsgroups'][$sg->getSgid()])){
            $nonmemberdependentlist[$nm->getNmemid()]['sportsgroups'][$sg->getSgid()]=$sg;
            } 
        }
    }
     

    foreach ($phonenumberlist as $pn){

        $nonmemberdependentlist[$pn->getNMemID()]['phonenumbers'][]=$pn;
    }


     foreach ($rehabcertlist as $rc){
        if($rc->getTerminationdate()->format("Y-m-d") > $now){
         $nonmemberdependentlist[$rc->getNMemID()]['validrehabcerts'][]=$rc;
        }else{
          $nonmemberdependentlist[$rc->getNMemID()]['expiredrehabcerts'][]=$rc;  
        }
         
     }
    
        return $this->render(
        'Nicht_Mitglieder/nonmember.html.twig',
        array(
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'nonmemberdependentlist' => $nonmemberdependentlist, 
            'cletter' => $letter,
            'tabledata' => $nonmemberlist, 

             'adminyear' => $adminyear,
            'path' => 'nonmember_home'
            ));
    }     
     /**
     * @Route("/nichtmitglieder/anlegen/{adminyear}/{letter}", defaults={"letter": "A" , "adminyear": 2016}, name="addnonmem", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})
     */
    public function addnonmeberAction(Request $request, $letter, $adminyear){
      
    $doctrine=$this->getDoctrine();   
    $manager= $doctrine->getManager();

    
    $nonmember = new Nonmember ();
    $phonenumber = new NonMemPhoneNumber();   
    $im=  new IndexManager ($manager,'NonMember');
            
    $fm= new FunctionManager($doctrine, $adminyear);

    
    $nmemid=$im->getCurrentIndex();
    $nonmember->setNMemID($nmemid);
    
    $nonmember->addPhonenumber($phonenumber);
    $addnonmemform = $this->createForm(BaseNonMemberType::class, $nonmember, array('adyear' => $adminyear));    
    
    $addnonmemform->handleRequest($request);     
        
        //if the form is valid -> persist it to the database
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid()){
                    
            
            $manager= $this->getDoctrine()->getManager();
            
            $nonmember->setValidfrom($adminyear)
                    ->setValidto('2155');
            
            foreach($nonmember->getPhonenumber() as $pn){
//              
                $fm->AddObject($pn, 'secondary');
               
            }
            
            foreach($nonmember->getRehabilitationcertificate() as $rc){
//              
                $fm->AddObject($rc, 'secondary');
                
            }
            
            foreach ($nonmember->getSportsgroup() as $sg){
                $fm->AddObject($sg,'secondary', array('entitypath' => 'AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup','idprefixone' => 'nmem','idone' => $nonmember->getNmemid()));
            }
            
            $manager->persist($nonmember);     
            $manager->flush();
            
            $im->add();
            $this->addflash('notice', 'Diese Person wurde erfolgreich angelegt!');
            
            return $this->redirectToRoute('nonmember_home', array ('letter'=>$letter, 'adminyear' => $adminyear));
            }
        
            
            
        return $this->render(
        'Nicht_Mitglieder/nonmemberform.html.twig',
        array(            
            'form' => $addnonmemform->createView(),
            'cletter' => $letter,
            'title' => 'Nichtmitglied anlegen',
            'adminyear' => $adminyear
            ));
        
    }
     /**
     * @Route("/nichtmitglieder/bearbeiten/{adminyear}/{letter}/{ID}", defaults={"letter": "A"}, requirements={"letter": "[A-Z]"}, name="editnonmem")
     * 
     */
    public function editnonmeberAction (Request $request, $adminyear, $ID, $letter){
        
    
    
    $doctrine=$this->getDoctrine();   
    $manager= $doctrine->getManager();
    
    $fm= new FunctionManager($doctrine, $adminyear);
    
    $validfrom=$request->query->get('version');
    $dependencies=array( 'Nichtmitglieder\NonMemPhoneNumber', 'Nichtmitglieder\NonMemRehabilitationCertificate','Nichtmitglieder\NonMember_Sportsgroup');

    
    $qb=[];
    foreach($dependencies as $dependent){
   
    //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$adminyear AND ditto.memid=§ID
    $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
    $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                   ->andWhere('ditto.validto>'.$adminyear)
                   ->andWhere('ditto.nmemid='.$ID);
        
    }
        
        
        $nonmember=$doctrine->getRepository('AppBundle:Nichtmitglieder\Nonmember')->findOneBy(array('nmemid' => $ID, 'validfrom'=>$validfrom));
        $nonmember_old = clone $nonmember;

        
        if (!$nonmember){
            throw $this->createNotFoundException('Es konnte kein Nichtmitglied mit der Nichtmitgliedsnr.: '.$ID.' gefunden werden');
        }
        $phonenumbers=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
        $rehabcerts=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
        $sportsgrouplist=$qb['Nichtmitglieder\NonMember_Sportsgroup']->getQuery()->getResult();

  
        
        $originalrehabs = new ArrayCollection();
        $originalphonenrs = new ArrayCollection();
        $originalsportsgroups = new ArrayCollection();

//        $originalsections = new ArrayCollection();
        
            // Create an ArrayCollection of the current Rehab objects in the database
         foreach ($rehabcerts as $rehab) {
             $origininalrehab= clone $rehab;
             $nonmember->addRehabilitationcertificate($rehab);
             $originalrehabs->add($origininalrehab);
         }

         // Create an ArrayCollection of the current Phonenr objects in the database
         foreach ($phonenumbers as $phonenr) {

             $origininalphonenr= clone $phonenr;
             $nonmember->addPhonenumber($phonenr);
             $originalphonenrs->add($origininalphonenr);
         }
         
          foreach ($sportsgrouplist as $sport) {
             $sp=$doctrine->getRepository('AppBundle:Nichtmitglieder\NonMemSportsgroup')->findOneBy(array('sgid' => $sport->getSgid(), 'validfrom'=>$validfrom));
             
             $originalsportsgroup= clone $sp;          
             $nonmember->addSportsgroup($sp);
             $originalsportsgroups->add($originalsportsgroup);
         }
         
//        echo '<pre>';
//        print_r($originalsportsgroup);
//        echo '</pre>';
        
        
        $editnonmemform = $this->createForm(EditNonMemberType::class, $nonmember, array('adyear' => $adminyear));
        $editnonmemform->handleRequest($request);
         
        if($editnonmemform->get('delete')->isClicked()){
           
            $fm->RemoveObject($nonmember, array('Nichtmitglieder\NonMemPhoneNumber', 'Nichtmitglieder\NonMemRehabilitationCertificate'));
           
           $manager->flush();
            $this->addflash('notice', 'Dieses Nichtmitglied wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'entfernt'));
        
        }
        //if the form is valid -> persist it to the database
       if($editnonmemform->isSubmitted() && $editnonmemform->isValid()){ 

            $fm->HandleDependencyDiff($nonmember->getRehabilitationcertificate(), $originalrehabs);
            $fm->HandleDependencyDiff($nonmember->getPhonenumber(), $originalphonenrs);
            $fm->HandleDependencyDiff($nonmember->getSportsgroup(), $originalsportsgroups, array('entitypath' => 'AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup','idprefixone' => 'nmem','idone' => $nonmember->getNmemid()));

            $fm->HandleObjectDiff($nonmember, $nonmember_old);

            $manager->flush();
            
            
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'adminyear' => $adminyear));    
       
       }

        
        return $this->render(
                'Nicht_Mitglieder/nonmemberform.html.twig',
                 array(
            
            'form' => $editnonmemform->createView(),
            'cletter' => $letter,
            'title' => 'Nichtmitglied bearbeiten',
                     'adminyear' => $adminyear
            ));
    }
}

        

