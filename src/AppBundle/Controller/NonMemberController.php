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
     * @Route("/nichtmitglieder/{letter}", defaults={"letter"="A"}, name="nonmember_home", requirements={"letter": "[A-Z]"})
    */    
    public function indexAction (Request $request, $letter ) {   
  
      
    $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Nichtmitglieder\Nonmember');
    
    $qb=$repository->createQueryBuilder('n');
    
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
    
    if($searchcol=='token'){
    $query=$qb->Join('n.sportsgroup', 'i')           
            ->where($qb->expr()->like('i.token',':tok'))
            ->setParameter('tok','%'.$searchval.'%')
            ->getQuery();
    }else 
    if($searchcol=='terminationdate'){
    $query=$qb->Join('n.rehabilitationcertificate', 'i')           
            ->where($qb->expr()->like('i.terminationdate',':token'))
            ->setParameter('token','%'.$searchval.'%')
            ->getQuery();
    }else{
    $query=$qb->where($qb->expr()->like('n.'.$searchcol, ':nonmember'))
                   ->setParameter('nonmember','%'.$searchval.'%')
                   ->getQuery();
    } 
    
    
//    $query=$qb->where($qb->expr()->like('n.'.$searchcol, ':nonmember'))
//                   ->setParameter('nonmember','%'.$searchval.'%')
//                   ->getQuery();
    
    $nonmemberlist=$query->getResult();
    $disabled='';
    
    
    }    
    else
    {
    $query=$qb->where($qb->expr()->like('n.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
    
        switch($letter){
            case 'A': $qb->orWhere($qb->expr()->like('n.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb->orWhere($qb->expr()->like('n.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb->orWhere($qb->expr()->like('n.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }
 
        $nonmemberlist=$query->getQuery()->getResult();
        $disabled='disabled';
        
    }
        return $this->render(
        'Nicht_Mitglieder/nonmember.html.twig',
        array('info' => NULL,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'disabled' => $disabled,
            'cletter' => $letter,
            'tabledata' => $nonmemberlist, 
            'path' => 'nonmember_home'
            ));
    }     
      /**
     * @Route("/nichtmitglieder/anlegen/{letter}", defaults={"letter": "A"}, name="addnonmem", requirements={"letter": "[A-Z]"})
     * 
     */
    public function addnonmeberAction (Request $request, $letter){
      
        
     $nonmember = new Nonmember ();
     $phonenumber = new NonMemPhoneNumber();
     
     $nonmember->setNmemid(101);
     $phonenumber->setPhid(101);
     
     $today = new \DateTime('now');
     $nonmember->setRecorded($today->format('Y-m-d'));
     $phonenumber->setRecorded($today->format('Y-m-d'));
     
     $nonmember->addPhonenumber($phonenumber);
        
        $addnonmemform = $this->createForm(AddNonMemberType::class, $nonmember);
        $addnonmemform->handleRequest($request);     
        
        //if the form is valid -> persist it to the database
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid()){
           if(!empty($nonmember->getSportsgroup())){
            foreach($nonmember->getSportsgroup() as $sportsgroup) {
                foreach($sportsgroup->getSection() as $section) {              
                $nonmember->addSection($section);
                }                
            }
        }
            
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($nonmember);     
            $manager->flush();
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
     * @Route("/nichtmitglieder/bearbeiten/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"ID": "\d+", "letter": "[A-Z]"}, name="editnonmem")
     * 
     */
    public function editnonmeberAction (Request $request, $ID, $letter){
        $manager=$this->getDoctrine()->getManager();
        $repository = $this ->getDoctrine()->getRepository('AppBundle:Nichtmitglieder\Nonmember');
        $nonmember=$repository->findOneBy(array('nmemid' => $ID));
        
        if (!$nonmember){
            throw $this->createNotFoundForm('Es konnte kein Mitglied mit der Nichtmitgliedsnr.: '.$ID.' gefunden werden');
        }
        $editnonmemform = $this->createForm(EditNonMemberType::class, $nonmember);
        
        $originalrehabs = new ArrayCollection();
        
        // Create an ArrayCollection of the current Rehab objects in the database
        foreach ($nonmember->getRehabilitationcertificate() as $rehab) {
            $originalrehabs->add($rehab);
        }
        
        $editnonmemform->handleRequest($request);
         
        if($editnonmemform->get('delete')->isClicked()){
            $manager=$this->getDoctrine()->getManager();
            $manager->remove($nonmember);
            $manager->flush();
            $this->addflash('notice', 'Diese Person wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'entfernt'));
        } 
        
         //if the form is valid -> persist it to the database
        if($editnonmemform->isSubmitted() && $editnonmemform->isValid()){ 
           
            foreach ($originalrehabs as $rehab) {
        
                if (false === $nonmember->getRehabilitationcertificate()->contains($rehab)) {
                    $manager->remove($rehab);
                }
            }     
            $manager->persist($nonmember);          
            $manager->flush();              
            $this->addflash('notice', 'Dies Daten wurden erfolgreich gespeichert!');
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

        

