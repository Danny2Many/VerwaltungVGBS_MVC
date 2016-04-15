<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\Nonmember;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Nichtmitglieder\AddNonMemberType;
use AppBundle\Form\Type\Nichtmitglieder\EditNonMemberType;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\FormBuilder;
use AppBundle\Entity\Section;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\SanitizedTextType;

class NonMemberController extends Controller {
    /**
     * @Route("/nichtmitglieder/{adminyear}/{letter}", defaults={"letter"="A", "adminyear"=2016}, name="nonmember_home", requirements={"letter": "[A-Z]", "adminyear": "[1-9][0-9]{3}"})

    */    
    public function indexAction (Request $request, $letter, $adminyear ) {   
  
    //if $adminyear is the current year
     if($adminyear == date('Y')){
     
     $now=date("Y");
     
     }
     //else take the last day of the choosen year
     else{
         $now=$adminyear;
     }
     
    $doctrine = $this->getDoctrine();
    $dependencies=array('Nichtmitglieder\Nonmember' => 'nmem', 'Nichtmitglieder\NonMemPhoneNumber' => 'pn', 'Nichtmitglieder\NonMemRehabilitationCertificate' => 'rc');
    $qb=[];
      foreach($dependencies as $dependent => $idprefix){
   
        //building the subquery: SELECT max(validfrom) FROM % AS dittosub WHERE dittosub.type = ditto.type
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.validfrom'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id')
                           ->andWhere('dittosub.validfrom<='.$now)
                     ->andWhere('dittosub.validto>'.$now);
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.validfrom=( subquery ) AND ditto.validfrom<=$adminyear 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.validfrom=('.$qb[$dependent.'sub']->getDQL().')')
                 ;
    }
    
    
    $choices=array('Nichtmitgliedsnr.' => 'nmemid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Straße' => 'streetaddress',
        'E-Mail' => 'email',
        'Sportgruppe' => 'token',
        'RS-Ablaufd.' => 'terminationdate',
        'Krankenkasse' => 'healthinsurance');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('nonmember_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
        //setting the letter to null for the pagination not to show any letter
        $letter=null;   
        //getting the values of the field and column
        $searchval=$request->query->get('search')['searchfield'];
        $searchcol=$request->query->get('search')['column'];
    
    if($searchcol=='terminationdate'){
        $qb['Nichtmitglieder\NonMemRehabilitationCertificate']->andWhere($qb['Nichtmitglieder\NonMemRehabilitationCertificate']->expr()->like('ditto.'.$searchcol,':type'))
            ->setParameter('type','%'.$searchval.'%');

            $rehacelist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();

            if($rehacelist){          
                foreach ($rehacelist as $rc){         
                $idarray[]=$rc->getNmemid();     
            }

            $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\NonMemRehabilitationCertificate']->expr()->in('ditto.nmemid', $idarray));
            $qb['Nichtmitglieder\NonMemRehabilitationCertificate']->orWhere($qb['Nichtmitglieder\Nonmember']->expr()->in('ditto.nmemid', $idarray));
            
            }else{
                $qb['Nichtmitgleider\Nonmember']->andWhere('ditto.nmemid<=:abort')->setParameter('abort',-1);
            }
    }else{
    $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.'.$searchcol, ':nonmember'))
               ->setParameter('nonmember','%'.$searchval.'%');
    } 
        
    }else{        
        
        $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');                
        
        
          switch($letter){
            case 'A': $qb['Nichtmitglieder\Nonmember']->orWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb['Nichtmitglieder\Nonmember']->orWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb['Nichtmitglieder\Nonmember']->orWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }    
    }    
    //get the builded queries
    $nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    $phonenumberlist=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
    $rehabcertlist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
  
    $nonmemberdependentlist=[];
    foreach ($phonenumberlist as $pn){

        $nonmemberdependentlist[$pn->getNMemID()]['phonenumbers'][]=$pn;
    }


     foreach ($rehabcertlist as $rc){
        if($rc->getTerminationdate()->format("Y") > $now){
         $nonmemberdependentlist[$rc->getNMemid()]['validrehabcerts'][]=$rc;
        }else{
          $nonmemberdependentlist[$rc->getNMemid()]['expiredrehabcerts'][]=$rc;  
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
      

    $nonmember = new Nonmember ();
    $phonenumber = new NonMemPhoneNumber();   
    $im=  $this->get('app.index_manager')

                   ->setEntityName('NonMember');

    echo $adminyear;
    $nmemid=$im->getCurrentIndex();
    $nonmember->setNMemID($nmemid);
    
    $nonmember->addPhonenumber($phonenumber);
    $addnonmemform = $this->createForm(AddNonMemberType::class, $nonmember);    
    
    $addnonmemform->handleRequest($request);     
        
        //if the form is valid -> persist it to the database
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid()){
                    
            
            $manager= $this->getDoctrine()->getManager();
            
            $nonmember->setValidfrom($adminyear)
                    ->setValidto('2155');
            
            foreach($nonmember->getPhonenumber() as $pn){
                $pn->setPnid(uniqid('pn'))
                ->setValidfrom($adminyear)
                 ->setValidto('2155');
                $manager->persist($pn);
            }
            
            foreach($nonmember->getRehabilitationcertificate() as $rc){
                $rc->setRcid(uniqid('rc'))
                ->setValidfrom($adminyear)
                 ->setValidto('2155');
                $manager->persist($rc);
            }
            
            $manager->persist($nonmember);     
            $manager->flush();
            
            $im->add();
            $this->addflash('notice', 'Diese Person wurde erfolgreich angelegt!');
            
            return $this->redirectToRoute('nonmember_home', array ('letter'=>$letter));
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
    $dependencies=array('Nichtmitglieder\Nonmember' => 'nmem', 'Nichtmitglieder\NonMemPhoneNumber'=> 'pn', 'Nichtmitglieder\NonMemRehabilitationCertificate'=> 'rc');
    
    $qb=[];
    foreach($dependencies as $dependent => $idprefix){
   //building the subquery: SELECT max(recorded) FROM % AS dittosub WHERE dittosub.type = ditto.type
    $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
    $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.validfrom'))
                                ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');  
 
    //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$adminyear AND ditto.memid=§ID
    $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
    $qb[$dependent]->where('ditto.validfrom=('.$qb[$dependent.'sub']->getDQL().')')                
                   ->andWhere('ditto.nmemid = :ID')     
                   ->andWhere('ditto.validfrom <= :adminyear')
                   ->andWhere('ditto.validto>:adminyear')
                   ->setParameter('ID', $ID)
                   ->setParameter('adminyear',$adminyear);
     
    }
        
        
        $nonmember=$qb['Nichtmitglieder\Nonmember']->getQuery()->getSingleResult();
        
        if (!$nonmember){
            throw $this->createNotFoundForm('Es konnte kein Nichtmitglied mit der Nichtmitgliedsnr.: '.$ID.' gefunden werden');
        }
        $phonenumbers=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
        $rehabcerts=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
        
        echo '<pre>'; 
        print_r($rehabcerts);
        echo '</pre>';
        
        $originalrehabs = new ArrayCollection();
        $originalphonenr = new ArrayCollection();
//        $originalsections = new ArrayCollection();
        
        // Create an ArrayCollection of the current Rehab objects in the database
         foreach ($rehabcerts as $rehab) {
            $nonmember->addRehabilitationcertificate($rehab);
            $originalrehabs->add($rehab);
        }
     
        // Create an ArrayCollection of the current Phonenr objects in the database
        foreach ($phonenumbers as $phonenr) {
            $nonmember->addPhonenumber($phonenr);
            $originalphonenr->add($phonenr);
        }
        // Create an ArrayCollection of the current Rehab objects in the database
        //    foreach ($member->getSection() as $section) {
        //        
        //        $originalsections->add($section);
        //    }
        $editnonmemform = $this->createForm(EditNonMemberType::class, $nonmember);
        $editnonmemform->handleRequest($request);
         
        if($editnonmemform->get('delete')->isClicked()){
            $manager->remove($nonmember);
            $manager->flush();
            $this->addflash('notice', 'Dieser Nichtmitglied wurde erfolgreich gelöscht!');            
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'entfernt'));
        
        }
        //if the form is valid -> persist it to the database
       if($editnonmemform->isSubmitted() && $editnonmemform->isValid()){ 
//            if(!$nonmember->getSportsgroup()->isEmpty()){      
//            foreach ($nonmember->getSportsgroup() as $sportsgroup) {
//                foreach ($originalsections as $section) {
//                    if (false === $sportsgroup->getSection()->contains($section)) {
//                        $nonmember->removeSection($section);
//                    }
//                }
//            }
//
//            foreach($nonmember->getSportsgroup() as $sportsgroup){
//                foreach($sportsgroup->getSection() as $section){
//                    $nonmember->addSection($section);
//                }
//            }
//
//        }else{
//            $nonmember->getSection()->clear();
//        }
        foreach ($originalrehabs as $rehab) {
            if (false === $nonmember->getRehabilitationcertificate()->contains($rehab)) {
                $manager->remove($rehab);
            }
        }     
         foreach ($originalphonenr as $phonenr) {
            if (false === $nonmember->getPhonenumber()->contains($phonenr)) {         
                $manager->remove($phonenr);
            }
        }
        
        foreach($nonmember->getRehabilitationcertificate() as $rc){
                if (false == $originalrehabs->contains($rc)) {
                     $rc->setRcid(uniqid('rc'))
                        ->setValidfrom($adminyear)
                        ->setValidto('2155');
                     $manager->persist($rc);              
                }            
        }
        
        foreach($nonmember->getPhonenumber() as $pn){
                if (false == $originalphonenr->contains($pn)) {
                     $pn->setPnid(uniqid('pn'))
                        ->setValidfrom($adminyear)
                        ->setValidto('2155');
                     $manager->persist($pn);              
                }            
        }
           
            //if the form is valid -> persist it to the database
//       
//   
//          foreach ($originalrehabs as $rehab) {
//            if (false === $nonmember->getRehabilitationcertificate()->contains($rehab)) {
//                
//
//                $manager->remove($rehab);
//
//            }
//        }
//            
//            foreach ($originalphonenr as $phonenr) {
//            if (false === $nonmember->getPhonenumber()->contains($phonenr)) {
//                
//
//                $manager->remove($phonenr);
//
//            }
//        }
           
            $manager->persist($nonmember);          
            $manager->flush();     
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'gespeichert'));    
       
        
            
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

        

