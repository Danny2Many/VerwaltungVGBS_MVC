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
use Symfony\Component\Config\Definition\Exception\Exception;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Services\FunctionManager;
use AppBundle\Services\IndexManager;



class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016},name="trainer_home", requirements={"letter": "[A-Z]|alle", "adminyear": "[1-9][0-9]{3}"})
     */
    public function indexAction (Request $request, $letter, $adminyear)
    {       
        
        $doctrine=$this->getDoctrine();
        $dependencies=['Trainer\Trainer', 'Trainer\TrainerPhoneNumber', 'Trainer\TrainerFocus','Trainer\TrainerLicence', 'Nichtmitglieder\NonMemSportsgroup', 'Nichtmitglieder\Trainer_NonMemSportsgroupSub'];
    
        $qb= [];
        
        foreach($dependencies as $dependent){ 

            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent] ->andWhere('ditto.validfrom<='.$adminyear)
                            ->andWhere('ditto.validto>'.$adminyear);   
    }    
        
        $choices=array('Trainernr.' => 'trainerid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email',
        'Lizenz' => 'licencetype');      

        
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('trainer_home',array('adminyear' => $adminyear))));    
        
    $searchform->handleRequest($request);    
  
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];   
    
    
     if($searchcol=='licencetype'){
    $lqb = clone $qb['Trainer\TrainerLicence'];
    $lqb->andWhere($lqb->expr()->like('ditto.'.$searchcol,':type'))
        ->setParameter('type','%'.$searchval.'%');
       
        $licencelist=$lqb->getQuery()->getResult();
     
        if($licencelist){          
            foreach ($licencelist as $lc){         
            $idarray[]=$lc->getTrainerid();     
            }    
        }else{
            $idarray=array(null);
        }
        $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->in('ditto.trainerid', $idarray));

    }else{  
        
    $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.'.$searchcol, ':trainer'))
        ->setParameter('trainer','%'.$searchval.'%');  
    }
         
    }else if($letter != 'alle'){
          
        $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
        
        switch($letter){
            case 'A': $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }        
    }else{ $letter=null; }    
        
    $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
    $phonenumberlist=$qb['Trainer\TrainerPhoneNumber']->getQuery()->getResult();
    $licencelist=$qb['Trainer\TrainerLicence']->getQuery()->getResult();
    $focuslist=$qb['Trainer\TrainerFocus']->getQuery()->getResult();
    $nmemsportsgrouplist=$qb['Nichtmitglieder\NonMemSportsgroup']->getQuery()->getResult();
    $nmemsportsgroupsublist=$qb['Nichtmitglieder\Trainer_NonMemSportsgroupSub']->getQuery()->getResult();

    
//         echo ("<pre>");
//         print_r($nmemsportsgroupsublist);
//        echo ("</pre>");

     
 
    
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
     
     foreach ($nmemsportsgrouplist as $sg){
         
         $trainerdependentlist[$sg->getTrainerid()]['nmemsportsgroups'][]=$sg;
     }
     
     foreach ($nmemsportsgroupsublist as $sgs){
         
         $trainerdependentlist[$sgs->getTrainerid()]['nmemsportsgroupssub'][$sgs->getSgid()]=$sgs->getSgid();
     }

        foreach ($trainerlist as $sg){
           foreach ($nmemsportsgrouplist as $tr){
               if(isset($trainerdependentlist[$sg->getTrainerid()]['nmemsportsgroupssub'][$tr->getSgid()])){
               $trainerdependentlist[$sg->getTrainerid()]['nmemsportsgroupssub'][$tr->getSgid()]=$tr; 
               }
    }
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
     * @Route("/trainer/anlegen/{adminyear}/{letter}", defaults={"letter": "alle", "adminyear": 2016}, name="addtrainer", requirements={"letter": "[A-Z]|alle","adminyear": "[1-9][0-9]{3}"})
     */    
    public function addtrainerAction(Request $request, $letter, $adminyear) {        
        
        $manager= $this->getDoctrine()->getManager();

        
        $trainer = new Trainer();
        $phonenumber = new TrainerPhoneNumber();
        $licence = new TrainerLicence();  
        
        $im= new IndexManager($manager, 'Trainer');

        $trainerid=$im->getCurrentIndex();
        $trainer->setTrainerid($trainerid);
        
        
        $trainer->addPhonenumber($phonenumber);
        $trainer->addLicence($licence);
        
        
        $addtrainerform = $this->createForm(AddTrainerType::class, $trainer);
        
        $addtrainerform->handleRequest($request);
        
        if ($addtrainerform->isSubmitted() && $addtrainerform->isValid()){
            
            
            $manager= $this->getDoctrine()->getManager();
            
            $trainer->setValidfrom($adminyear)->setValidto('2155');
     
            foreach($trainer->getPhonenumber() as $pn){
                 $pn->setTpnid(uniqid('pn'))
                    ->setValidfrom($adminyear)
                    ->setValidto('2155');
                 $manager->persist($pn);              
            }
            
            foreach($trainer->getLicence() as $lc){
                $lc->setLiid(uniqid('lc'))    
                    ->setValidfrom($adminyear)
                    ->setValidto('2155');
                $manager->persist($lc);              
            }
          
            foreach($trainer->getTheme() as $th){
                $th->setTfid(uniqid('th'))                        
                    ->setValidfrom($adminyear)
                    ->setValidto('2155');
                $manager->persist($th);              
            }
                 

            $manager->persist($trainer);
          
            $manager->flush();  
            $im->add();
            
            
            $this->addFlash('notice', 'Dieser Übungsleiter wurde erfolgreich angelegt!');
            return $this->redirectToRoute('trainer_home', array('letter' => $letter, 'adminyear' => $adminyear));
        }

        
        return $this->render('Trainer/trainerform.html.twig',
                array(
                    'form'=>$addtrainerform->createView(),                    
                    'cletter'=>$letter,
                    'title'=>'Übungsleiter anlegen',
                    'adminyear' => $adminyear,
                    'path'=>'addtrainer'));        
    }
    
    
//-------------------------------------------------------------------------------------------------   
    
    /**
     * @Route("/trainer/bearbeiten/{adminyear}/{letter}/{ID}", defaults={"letter": "alle"}, requirements={"letter": "[A-Z]|alle"}, name="edittrainer")
     * 
     */   
    public function edittrainerAction(Request $request, $adminyear, $ID, $letter)
    {
        $doctrine= $this->getDoctrine();
        $manager= $doctrine->getManager();
        
        $validfrom=$request->query->get('validfrom');
        
        $fm= new FunctionManager($doctrine, $adminyear);       
        
        $dependencies=['Trainer\TrainerPhoneNumber', 'Trainer\TrainerFocus','Trainer\TrainerLicence'];

        $qb= [];
        
        foreach($dependencies as $dependent){          
                      
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            $qb[$dependent]->andWhere('ditto.validfrom<='.$adminyear)
                            ->andWhere('ditto.validto>'.$adminyear) 
                            ->andWhere('ditto.trainerid='.$ID);
            
        }
        
        $trainer=$doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy(array('trainerid' => $ID, 'validfrom'=>$validfrom));
       
        $trainer_old = clone $trainer;    
        
        
        if(!$trainer){
            throw $this->createNotFoundException('Es konnte kein Trainer mit der Trainernr.: '.$ID.' gefunden werden');
        }
        
        $phonenumbers=$qb['Trainer\TrainerPhoneNumber']->getQuery()->getResult();
        $licences=$qb['Trainer\TrainerLicence']->getQuery()->getResult();        
        $focuses=$qb['Trainer\TrainerFocus']->getQuery()->getResult();        

        $originallicences = new ArrayCollection();
        $originalphonenr = new ArrayCollection();
        $originalthemes = new ArrayCollection();

        
        foreach ($licences as $licence) {
            $trainer->addLicence($licence);
            $licenceoriginal = clone $licence;
            $originallicences->add($licenceoriginal);
        }   
        
        foreach ($phonenumbers as $phonenr) {
            $trainer->addPhonenumber($phonenr);
            $phonenroriginal = clone $phonenr;
            $originalphonenr->add($phonenroriginal);
        } 
        
        foreach ($focuses as $theme) {
            $trainer->addTheme($theme);
            $originalfocus = clone $theme;
            $originalthemes->add($originalfocus);
        }
    
        
        $edittrainerform = $this->createForm(EditTrainerType::class, $trainer);
        $edittrainerform -> handleRequest($request);
        
        
        if($edittrainerform->get('delete')->isClicked()){
            
           $fm->RemoveObject($trainer, array('Trainer\TrainerFocus', 'Trainer\TrainerPhonenumber', 'Trainer\TrainerLicence'));

            
            
            $manager->flush();
            $this->addflash('notice', 'Dieser Übungsleiter wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('trainer_home', array('letter' => $letter,'adminyear' => $adminyear));
        }        
        
        
                
        if($edittrainerform->isSubmitted() && $edittrainerform->isValid()){
  
            $fm->HandleDependencyDiff($trainer->getLicence(), $originallicences);
            $fm->HandleDependencyDiff($trainer->getPhonenumber(), $originalphonenr);
            $fm->HandleDependencyDiff($trainer->getTheme(), $originalthemes);

            $fm->HandleObjectDiff($trainer, $trainer_old);

            $manager->flush();
            

            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');
           
          return $this->redirectToRoute('trainer_home', array('letter' => $letter, 'adminyear' => $adminyear));  
        }
        
        return $this->render('Trainer/trainerform.html.twig',
        array(            
            'form' => $edittrainerform->createView(),
            'cletter' => $letter,
            'title' => 'Trainer bearbeiten',
            'adminyear' => $adminyear,
            'path'=>'edittrainer',
            'ID'=>$ID,
            ));
    }
}