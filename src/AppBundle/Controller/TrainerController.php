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
use \DateTime;
use AppBundle\Form\Type\Member\EditMemberType;

use Doctrine\Common\Collections\ArrayCollection;









class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016},name="trainer_home", requirements={"letter": "[A-Z]|alle", "adminyear": "[1-9][0-9]{3}"})
     */
    public function indexAction (Request $request, $letter, $adminyear)
    {
        
        $doctrine=$this->getDoctrine();
        $dependencies=['Trainer\Trainer' => 'trainer', 'Trainer\TrainerPhoneNumber' =>'tpn', 'Trainer\TrainerFocus'=>'tf','Trainer\TrainerLicence'=>'li'];
    
        $qb= [];
        foreach($dependencies as $dependent => $idprefix){
     
            $qb[$dependent.'sub'] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('dittosub');
            $qb[$dependent.'sub']->select($qb[$dependent.'sub']->expr()->max('dittosub.recorded'))
                    ->where('dittosub.'.$idprefix.'id=ditto.'.$idprefix.'id');
            
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->where('ditto.recorded=('.$qb[$dependent.'sub']->getDQL().')')
                    ->andWhere('ditto.recorded<=:adminyear')
                    ->setParameter('adminyear',$adminyear.'-12-31');
     
    }
        
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
    
    
    
//    $qb['Trainer\Trainer']->where($qb['Trainer\Trainer']->expr()->like('ditto.'.$searchcol, ':trainer'))
//        ->setParameter('trainer','%'.$searchval.'%')
//        ->getQuery();
    
//     if($searchcol=='licencetype'){
//    $qb['Trainer\TrainerLicence']
////            ->Join('ditto.licence', 'i')           
//        ->where($qb['Trainer\TrainerLicence']->expr()->like('ditto.'.$searchcol,':type'))
//        ->setParameter('type','%'.$searchval.'%')
//        
//    }else{
    $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.'.$searchcol, ':trainer'))
        ->setParameter('trainer','%'.$searchval.'%');
  
//    }
         
    }else if($letter != 'alle'){
          
        $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
        
        switch($letter){
            case 'A': $qb['Trainer\Trainer']->orWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb['TrainTrainer\Trainerer']->orWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb['Trainer\Trainer']->orWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }        
    }else{ $letter=null; }    
        
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    $phonenumberlist=$qb['Trainer\TrainerPhoneNumber']->getQuery()->getResult();
    $licencelist=$qb['Trainer\TrainerLicence']->getQuery()->getResult();
    $focuslist=$qb['Trainer\TrainerFocus']->getQuery()->getResult();
    
    $trainerdependentlist=[];
     foreach ($phonenumberlist as $pn){
         
         $trainerdependentlist[$pn->getTrainerid()]['phonenumbers'][]=$pn;
     }
     
     foreach ($licencelist as $lc){
         
         $trainerdependentlist[$lc->getTrainerid()]['licences'][]=$lc;
     }

     foreach ($focuslist as $fc){
         
         $trainerdependentlist[$fc->getTrainerid()]['focuses'][]=$fc;
     }


        return $this->render('Trainer/trainer.html.twig',
                array('tabledata'=>$trainerlist,
                    'colorclass'=>"bluetheader",
                    'searchform'=>$searchform->createView(),
                    'trainerdependentlist' => $trainerdependentlist,         
                    'cletter'=>$letter,
                    'adminyear' => $adminyear,
                    'path'=>'trainer_home'));
    }
    
    
    
//  ------------------------------------------------------------------------------------------------------------------------------
    
    
    /**
     * @Route("/trainer/anlegen/{adminyear}/{letter}", defaults={"letter": "A", "adminyear": 2016}, name="addtrainer", requirements={"letter": "[A-Z]","adminyear": "[1-9][0-9]{3}"})
     */    
    public function addtrainerAction(Request $request, $letter, $adminyear) {        
        
        $trainer = new Trainer();
        $phonenumber = new TrainerPhoneNumber();
        $licence = new TrainerLicence();     
        
        
        $trainer->addPhonenumber($phonenumber);
        $trainer->addLicence($licence);
        
        
        $addtrainerform = $this->createForm(AddTrainerType::class, $trainer);
        
        $addtrainerform->handleRequest($request);
        
        if ($addtrainerform->isSubmitted() && $addtrainerform->isValid()){
            
            $trainerid=uniqid('tr'); 
            $trainer->setTrainerid($trainerid);            
         
            $manager= $this->getDoctrine()->getManager();
                        
            foreach($trainer->getPhonenumber() as $pn){
                 $pn->setTpnid(uniqid('pn'));
                 $manager->persist($pn);              
            }
            
            foreach($trainer->getLicence() as $lc){
                $lc->setLiid(uniqid('lc'));
                $manager->persist($lc);              
            }
          
            foreach($trainer->getTheme() as $th){
                $th->setTfid(uniqid('th'));
                $manager->persist($th);              
            }
          
          
          

            $manager->persist($trainer);
          
            $manager->flush();           
            $this->addFlash('notice', 'Dieser Übungsleiter wurde erfolgreich angelegt!');
            
            return $this->redirectToRoute('trainer_home', array('letter' => $letter));
        }

        
        return $this->render('Trainer/trainerform.html.twig',
                array(
                    'form'=>$addtrainerform->createView(),                    
                    'cletter'=>$letter,
                    'title'=>'Übungsleiter anlegen'));        
    }
    
    
//-------------------------------------------------------------------------------------------------   
    
    /**
     * @Route("/trainer/bearbeiten/{adminyear}/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"letter": "[A-Z]"}, name="edittrainer")
     * 
     */   
    public function edittrainerAction(Request $request, $adminyear, $ID, $letter)
    {
        $doctrine= $this->getDoctrine();
        $dependencies=['Trainer\Trainer' => 'trainer', 'Trainer\TrainerPhoneNumber'=>'tpn', 'Trainer\TrainerFocus'=>'tf','Trainer\TrainerLicence'=>'li'];

        $qb= [];
        foreach($dependencies as $dependent => $idprefix){
     
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->select(array('ditto', $qb[$dependent]->expr()->max('ditto.recorded')))
                    ->where('ditto.recorded <= :year')
                    ->andWhere('ditto.trainerid = :trainerid')
                    ->groupBy('ditto.'.$idprefix.'id')
                    ->setParameter('year', $adminyear.'-12-31')
                    ->setParameter('trainerid',$ID);     
        }
        
        $manager= $doctrine->getManager();
        $trainer=$qb['Trainer\Trainer']->getQuery()->getSingleResult()[0];
        
        
        
        if(!$trainer){
            throw $this->createNotFoundException('Es konnte kein Trainer mit der Trainernr.: '.$ID.' gefunden werden');
        }
        
        $phonenumbers=$qb['Trainer\TrainerPhoneNumber']->getQuery()->getResult()[0];
        $licences=$qb['Trainer\TrainerLicence']->getQuery()->getResult()[0];        
        $focuses=$qb['Trainer\TrainerFocus']->getQuery()->getResult()[0];        

        
        $originallicences = new ArrayCollection();
        $originalphonenr = new ArrayCollection();
        $originalthemes = new ArrayCollection();


        foreach ($licences as $licence) {
            $trainer->addLicence($licence);
            $originallicences->add($licence);
        }

        foreach ($phonenumbers as $phonenr) {
            $trainer->addPhonenumber($phonenr);
            $originalphonenr->add($phonenr);
        }
        
        foreach ($focuses as $theme) {
            $trainer->addTheme($theme);
            $originalthemes->add($theme);
        }
        
        $edittrainerform = $this->createForm(EditMemberType::class, $trainer);
        $edittrainerform -> handleRequest($request);
        
        if($edittrainerform->get('delete')->isClicked()){
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