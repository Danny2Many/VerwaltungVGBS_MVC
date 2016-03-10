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
use AppBundle\Entity\Section;
use Symfony\Component\Form\FormError;

class MemberController extends Controller
{
/**
     * @Route("/mitglieder/{letter}", defaults={"letter"="A"}, name="member_home", requirements={"letter": "[A-Z]"})
     */
    public function indexAction(Request $request, $letter)
    {
    

    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Member');
    
    $qb=$repository->createQueryBuilder('m');
    
    $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home')));
    
        
    $searchform->handleRequest($request);
    
    
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['Spalte'];
    
    
    
    
    $qb->where($qb->expr()->like('m.'.$searchcol, ':member'))
                   ->setParameter('member','%'.$searchval.'%')
                   ->getQuery();
    
    
     $disabled='';
     
    }else{
        
        
        $qb->where($qb->expr()->like('m.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
                   
        
        
          switch($letter){
            case 'A': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }
        
       
        
        
        $disabled='disabled';
    }
    
    
    
    
     $memberlist=$qb->getQuery()->getResult();

    return $this->render(
        'Mitglieder/member.html.twig',
        array(
            'tabledata' => $memberlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'disabled' => $disabled,           
            'cletter' => $letter,
            'path' => 'member_home'
           
         
            ));
    }
    
    
    
    
    /**
     * @Route("/mitglieder/anlegen/{letter}", defaults={"letter": "A"}, name="addmem", requirements={"letter": "[A-Z]"})
     * 
     */
    public function addmemberAction(Request $request, $letter)
    {
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        
        $section = new Section();
       
        $member->addSection($section);     
        $member->addPhonenumber($phonenumber);
               
      
        $addmemform = $this->createForm(AddMemberType::class, $member);
        
        
     
        $addmemform->handleRequest($request);
        
        

        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid()){
            

            
            
            $admcharge = $addmemform->get('admissioncharge')->getData();
            $member->setAdmissioncharge($admcharge);
            
            $admdate = $member->getAdmissiondate();
            $dues= $addmemform->get('dues')->getData();
          
          $repository=$this->getDoctrine()->getRepository('AppBundle:MemFinYear');
          
          $memfinyear=$repository->findOneBy(array('year' => $admdate->format('Y')));
          
          
          if($memfinyear != null){
          
          $yearinfo = new MemYearInfo();
          $yearinfo->setFinyear($memfinyear);
          
          $member->addYearinfo($yearinfo);
          
          $months=['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
          
          foreach ($months as $month){
          
          $$month= new MemMonthlyDues();
          $$month->setFinyear($memfinyear)
                  ->setMonth($month)
                  ->setDues($dues);
          $member->addMonthlydue($$month);
          }
     
            $manager= $this->getDoctrine()->getManager();
            
            $manager->persist($member);
            
          
            $manager->flush();
            
           $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!'); 
          return $this->redirectToRoute('member_home', array('letter' => $letter));
          }
          $addmemform->get('admissiondate')->addError(new FormError('Dieses Finanzjahr wurde noch nicht angelegt.'));
        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $addmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied anlegen'
            
            ));
    }
    
    
    
    
    /**
     * @Route("/mitglieder/bearbeiten/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"ID": "\d+", "letter": "[A-Z]"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $ID, $letter)
    {
        $manager= $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Member');
        
        $member=$repository->findOneBy(array('memid' => $ID));
        
        
     if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
       
      
        $editmemform = $this->createForm(EditMemberType::class, $member);
        
        
         $originalrehabs = new ArrayCollection();
         $originalphonenr = new ArrayCollection();

    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getRehabilitationcertificate() as $rehab) {
        $originalrehabs->add($rehab);
    }
     
    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getPhonenumber() as $phonenr) {
        $originalphonenr->add($phonenr);
    }
    
        $editmemform->handleRequest($request);
        
        
        if($editmemform->get('delete')->isClicked()){
            $manager=$this->getDoctrine()->getManager();
           
            $manager->remove($member);
            $manager->flush();
            $this->addFlash('notice', 'Diese Person wurde erfolgreich gelöscht!'); 
            return $this->redirectToRoute('member_home', array('letter' => $letter));
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
