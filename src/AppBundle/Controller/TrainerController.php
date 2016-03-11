<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Trainer\AddTrainerType;
use AppBundle\Entity\Trainer\Trainer;
use AppBundle\Entity\Trainer\TrainerPhoneNumber;
use AppBundle\Entity\Trainer\TrainerFocus;







class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{letter}/{all}", defaults={"letter"="A","all": null},name="trainer_home", requirements={"letter": "[A-Z]"})
     */
    public function indexAction (Request $request, $letter, $all)
    {
        
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:Trainer\Trainer');
        
        $qb=$repository->createQueryBuilder('t');
        
        $disabled='disabled';
        
        $choices=array('Trainernr.' => 'trainerid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('trainer_home')));    
        
    $searchform->handleRequest($request);    
  
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['Spalte'];   
    
    $qb->where($qb->expr()->like('t.'.$searchcol, ':trainer'))
                   ->setParameter('trainer','%'.$searchval.'%')
                   ;
    
     
    $disabled='';
         
    }else{ if($all == null){
          
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
                    'disabled' => $disabled,
                    'cletter'=>$letter,
                    'path'=>'trainer_home'));
    }}
    
    
    
//  ------------------------------------------------------------------------------------------------------------------------------
    
    
    /**
     * @Route("/trainer/anlegen/{letter}", defaults={"letter": "A"}, name="addtrainer", requirements={"letter": "[A-Z]"})
     */    
    public function addtrainerAction(Request $request, $letter) {
        
        
        $trainer = new Trainer();
        $focus = new TrainerFocus();
        
        $trainer->addFocus($focus);
        $trainer->addFocus($focus);

        
        
        

        
        $addtrainerform = $this->createForm(AddTrainerType::class, $trainer);
        
        $addtrainerform->handleRequest($request);
        if ($addtrainerform->isSubmitted() && $addtrainerform->isValid()){
            
                        
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($trainer);
            $manager->flush();            
            
            return $this->redirectToRoute('trainer_home', array('letter' => $letter, 'info' => 'gespeichert'));
        }

        
        return $this->render('Trainer/trainerform.html.twig',
                array('form'=>$addtrainerform->createView(),                    
                    'cletter'=>$letter,
                    'title'=>'Übungsleiter anlegen'));        
    }
    
}
