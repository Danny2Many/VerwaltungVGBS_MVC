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
     
     $now=date("Y-m-d");
     
     }
     //else take the last day of the choosen year
     else{
         $now=$adminyear.'-12-31';
     }
     
    $doctrine = $this->getDoctrine();
    $dependencies=array('Nichtmitglieder\Nonmember' => 'nmem', 'Nichtmitglieder\NonMemPhoneNumber' => 'pn', 'Nichtmitglieder\NonMemRehabilitationCertificate' => 'rc');
    $qb=[];
      foreach($dependencies as $dependent => $idprefix){
   
        //building the subquery: SELECT max(recorded) FROM % AS dittosub WHERE dittosub.type = ditto.type
     $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
     $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.recorded'))
                          ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
                          
        
     //building the query: SELECT ditto FROM % AS ditto WHERE ditto.recorded=( subquery ) AND ditto.recorded<=$adminyear 
     $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     $qb[$dependent]->where('ditto.recorded=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.recorded<=:adminyear')
                    ->setParameter('adminyear',$now);
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
        $letter=null;   
        $searchval=$request->query->get('search')['searchfield'];
        $searchcol=$request->query->get('search')['column'];
    
    //building the query
    $qb['Nichtmitglieder\Nonmember']->andWhere($qb['Nichtmitglieder\Nonmember']->expr()->like('ditto.'.$searchcol, ':nonmember'))
               ->setParameter('nonmember','%'.$searchval.'%');

        
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
  
    $nonmemberlist=$qb['Nichtmitglieder\Nonmember']->getQuery()->getResult();
    $phonenumberlist=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
    $rehabcertlist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();


    $nonmemberdependentlist=[];
    foreach ($phonenumberlist as $pn){

        $nonmemberdependentlist[$pn->getNMemID()]['phonenumbers'][]=$pn;
    }


     foreach ($rehabcertlist as $rc){
        if($rc->getTerminationdate()->format("Y-m-d") > $now){
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

     * 
     */
    public function addnonmeberAction (Request $request, $letter, $adminyear){
      

    $nonmember = new Nonmember ();
    $phonenumber = new NonMemPhoneNumber();   
    $im=  $this->get('app.index_manager')

                   ->setEntityName('NonMember');

    
    $nmemid=$im->getCurrentIndex();
    $nonmember->setNMemID($nmemid);
    
    $nonmember->addPhonenumber($phonenumber);
    $addnonmemform = $this->createForm(AddNonMemberType::class, $nonmember);    
    
    $addnonmemform->handleRequest($request);     
        
        //if the form is valid -> persist it to the database
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid()){
        
            
            
            $manager= $this->getDoctrine()->getManager();
            
            foreach($nonmember->getPhonenumber() as $pn){
                $pn->setPnid(uniqid('pn'));
                $manager->persist($pn);
            }
            
            foreach($nonmember->getRehabilitationcertificate() as $rc){
                $rc->setRcid(uniqid('rc'));
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
            'title' => 'Nichtmitglied anlegen'
            ));
        
    }
     /**
     * @Route("/nichtmitglieder/bearbeiten/{adminyear}/{letter}/{ID}", defaults={"letter": "[A-Z]"}, name="editnonmem")
     * 
     */
    public function editnonmeberAction (Request $request, $adminyear, $ID, $letter){
        
    $doctrine=$this->getDoctrine();   
    $dependencies=array('Nonmember' => 'nmem', 'NonMemPhoneNumber'=> 'pn', 'NonMemRehabilitationCertificate'=> 'rc');
    
    $qb=[];
    foreach($dependencies as $dependent => $idprefix){
            
    $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
    $qb[$dependent]->select(array('ditto', $qb[$dependent]->expr()->max('ditto.recorded')))
                ->where('ditto.recorded <= :year')
                ->andWhere('ditto.nmemid = :nmemid')
                ->groupBy('ditto.'.$idprefix.'id')
                ->setParameter('year', $adminyear.'-12-31')
                ->setParameter('nmemid', $ID);
     
    }
        
        $manager=getDoctrine()->getManager();
        $nonmember=$qb['Nonmember']->getQuery()->getSingleResult();
        
        if (!$nonmember){
            throw $this->createNotFoundForm('Es konnte kein Nichtmitglied mit der Nichtmitgliedsnr.: '.$ID.' gefunden werden');
        }
        $phonenumbers=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
        $rehabcerts=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
        
        $originalrehabs = new ArrayCollection();
        $originalphonenr = new ArrayCollection();
        $originalsections = new ArrayCollection();
        
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
        $editnonmemform = $this->createForm(EditMemberType::class, $nonmember);
        $editnonmemform->handleRequest($request);
         
        if($editnonmemform->get('delete')->isClicked()){
            $manager->remove($nonmember);
            $manager->flush();
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'entfernt'));
        
        }
         //if the form is valid -> persist it to the database
        if($editnonmemform->isSubmitted() && $editnonmemform->isValid()){ 
            if(!$nonmember->getSportsgroup()->isEmpty()){      
            foreach ($nonmember->getSportsgroup() as $sportsgroup) {
                foreach ($originalsections as $section) {
                    if (false === $sportsgroup->getSection()->contains($section)) {
                        $nonmember->removeSection($section);
                    }
                }
            }

            foreach($nonmember->getSportsgroup() as $sportsgroup){
                foreach($sportsgroup->getSection() as $section){
                    $nonmember->addSection($section);
                }
            }

        }else{
            $nonmember->getSection()->clear();
        }
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
            $manager->persist($nonmember);          
            $manager->flush();              
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'gespeichert'));    
       
        
            
        } 
        
        
        
        return $this->render(
                'Nicht_Mitglieder/nonmemberform.html.twig',
                 array(
            
            'form' => $editnonmemform->createView(),
            'cletter' => $letter,
            'title' => 'Nichtmitglied bearbeiten'
            ));
    }
}

        

