<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Trainer\AddTrainerType;
use AppBundle\Form\Type\Trainer\EditTrainerType;

use AppBundle\Entity\Trainer\Trainer;
use AppBundle\Entity\Trainer\TrainerPhoneNumber;
use AppBundle\Entity\Trainer\TrainerFocus;
use AppBundle\Entity\Trainer\TrainerLicence;

use Doctrine\Common\Collections\ArrayCollection;









class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{letter}", defaults={"letter"="alle"},name="trainer_home", requirements={"letter": "[A-Z]|alle"})
     */
    public function indexAction (Request $request, $letter)
    {
        
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:Trainer\Trainer');
        
        $qb=$repository->createQueryBuilder('t');
        
        $choices=array('Trainernr.' => 'trainerid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email',
        'Lizenz' => 'licencetype');     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('trainer_home')));    
        
    $searchform->handleRequest($request);    
  
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];   
    
    
    if($searchcol=='licencetype'){
    $qb->Join('t.licence', 'i')           
        ->where($qb->expr()->like('i.licencetype',':type'))
        ->setParameter('type','%'.$searchval.'%');
    }else{
    $qb->where($qb->expr()->like('t.'.$searchcol, ':trainer'))
        ->setParameter('trainer','%'.$searchval.'%');
    }
     
         
    }else if($letter != 'alle'){
          
        $qb->where($qb->expr()->like('t.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
        
        switch($letter){
            case 'A': $qb->orWhere($qb->expr()->like('t.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb->orWhere($qb->expr()->like('t.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb->orWhere($qb->expr()->like('t.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }        
    }else{ $letter=null; }    
        
    $trainerlist=$qb->getQuery()->getResult();
        return $this->render('Trainer/trainer.html.twig',
                array('tabledata'=>$trainerlist,
                    'colorclass'=>"bluetheader",
                    'searchform'=>$searchform->createView(),
                    'cletter'=>$letter,
                    'path'=>'trainer_home'));
    }
    
    
    
//  ------------------------------------------------------------------------------------------------------------------------------
    
    
    /**
     * @Route("/trainer/anlegen/{letter}", defaults={"letter": "A"}, name="addtrainer", requirements={"letter": "[A-Z]"})
     */    
    public function addtrainerAction(Request $request, $letter) {        
        
        $trainer = new Trainer();
        $phonenumber = new TrainerPhoneNumber();
        $licence = new TrainerLicence();
        
        $trainer->addPhonenumber($phonenumber);
        $trainer->addLicence($licence);
        
        $addtrainerform = $this->createForm(AddTrainerType::class, $trainer);
        
        $addtrainerform->handleRequest($request);
        if ($addtrainerform->isSubmitted() && $addtrainerform->isValid()){
            
                      
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($trainer);
            $manager->flush();            
            $this->addFlash('notice', 'Dieser Übungsleiter wurde erfolgreich angelegt!');
            
            return $this->redirectToRoute('trainer_home', array('letter' => $letter, 'info' => 'gespeichert'));
        }

        
        return $this->render('Trainer/trainerform.html.twig',
                array(
                    'form'=>$addtrainerform->createView(),                    
                    'cletter'=>$letter,
                    'title'=>'Übungsleiter anlegen'));        
    }
    
    
//-------------------------------------------------------------------------------------------------   
    
    /**
     * @Route("/trainer/bearbeiten/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"ID": "\d+", "letter": "[A-Z]"}, name="edittrainer")
     * 
     */   
    public function edittrainerAction(Request $request, $ID, $letter)
    {
        $manager= $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Trainer\Trainer');
        
        $trainer=$repository->findOneBy(array('trainerid' => $ID));
        
        if(!$trainer){
            throw $this->createNotFoundException('Es konnte kein Trainer mit der Trainernr.: '.$ID.' gefunden werden');
        }
        
        $edittrainerform = $this->createForm(EditTrainerType::class, $trainer);
        
        $originallicences = new ArrayCollection();
        $originalphonenr = new ArrayCollection();
        $originalthemes = new ArrayCollection();


        foreach ($trainer->getLicence() as $licence) {
            $originallicences->add($licence);
        }

        foreach ($trainer->getPhonenumber() as $phonenr) {
            $originalphonenr->add($phonenr);
        }
        
        foreach ($trainer->getTheme() as $theme) {
            $originalthemes->add($theme);
        }
        
        $edittrainerform->handleRequest($request);
        
        if($edittrainerform->get('delete')->isClicked()){
            $manager=$this->getDoctrine()->getManager();
            $manager->remove($trainer);
            $manager->flush();
            $this->addflash('notice', 'Dieser Übungsleiter wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('trainer_home', array('letter' => $letter));
        }
        
        if($edittrainerform->isSubmitted() && $edittrainerform->isValid()){
  
          foreach ($originallicences as $licence) {
            if (false === $trainer->getLicence()->contains($licence)) {   
                $manager->remove($licence);
            }
        }
            
            foreach ($originalphonenr as $phonenr) {
            if (false === $trainer->getPhonenumber()->contains($phonenr)) {         
                $manager->remove($phonenr);
            }
        }
        
            foreach ($originalthemes as $theme) {
            if (false === $trainer->getTheme()->contains($theme)) {         
                $manager->remove($theme);
            }
        }
           
            $manager->persist($trainer);          
            $manager->flush();
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');
           
          return $this->redirectToRoute('trainer_home', array('letter' => $letter));  
        }
        
        return $this->render('Trainer/trainerform.html.twig',
        array(            
            'form' => $edittrainerform->createView(),
            'cletter' => $letter,
            'title' => 'Trainer bearbeiten'
            ));
    }
}