<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Trainer\AddTrainerType;
use AppBundle\Form\Type\Trainer\EditTrainerType;

use AppBundle\Entity\Trainer\Trainer;
//use AppBundle\Entity\Trainer\TrainerPhoneNumber;
//use AppBundle\Entity\Trainer\TrainerFocus;
//use AppBundle\Entity\Trainer\TrainerLicence;
//use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\Common\Collections\ArrayCollection;

class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{letter}", defaults={"letter"="alle"},name="trainer_home", requirements={"letter": "[A-Z]|alle"})
     */
    public function indexAction (Request $request, $letter)
    {       
     $doctrine=$this->getDoctrine();
     $dependencies=['Trainer\Trainer','Trainer\TrainerFocus','Trainer\TrainerLicence','Trainer\TrainerPhoneNumber','Sportsgroup'];
     $qb= [];
        
     foreach($dependencies as $dependent)
     { 
      $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
     }    
        
     $qb['Trainer\Trainer']->add('select','ditto')
                           ->add('from','AppBundle\Entity\Trainer\Trainer ditto');
            
     $choices=array('Trainernr.' => 'trainerid',
     'Name' => 'lastname',
     'Vorname' => 'firstname',
     'Strasse' => 'streetaddress',
     'E-Mail' => 'email',
     'Lizenz' => 'licencetype');      
        
     $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('trainer_home')));
     $searchform->handleRequest($request);    
  
     if($searchform->isSubmitted() && $searchform->isValid())
     {
      $letter=null;   
      $searchval=$request->query->get('search')['searchfield'];
      $searchcol=$request->query->get('search')['column'];   
    
      if($searchcol=='licencetype')
      {
       $lqb = clone $qb['Trainer\TrainerLicence'];
       $lqb->andWhere($lqb->expr()->like('ditto.'.$searchcol,':type'))
           ->setParameter('type','%'.$searchval.'%');
       
       $licencelist=$lqb->getQuery()->getResult();
     
       if($licencelist)
       {          
        foreach ($licencelist as $lc)
        {         
         $idarray[]=$lc->getTrainerid();     
        }    
       }
       else
       {
        $idarray=array(null);
       }
       $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->in('ditto.trainerid', $idarray));

      }
      else
      {  
       $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.'.$searchcol, ':trainer'))
                             ->setParameter('trainer','%'.$searchval.'%');  
      }
     }
     else if($letter != 'alle')
     {          
      $qb['Trainer\Trainer']->andWhere($qb['Trainer\Trainer']->expr()->like('ditto.lastname', ':letter'))
                            ->setParameter('letter',$letter.'%');
        
      switch($letter)
      {
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
     }
     else
     {
      $letter=null;
     }    
        
     $trainerlist=$qb['Trainer\Trainer']->getQuery()->getResult();
     $phonenumberlist=$qb['Trainer\TrainerPhoneNumber']->getQuery()->getResult();
     $licencelist=$qb['Trainer\TrainerLicence']->getQuery()->getResult();
     $focuslist=$qb['Trainer\TrainerFocus']->getQuery()->getResult();
     $sportsgrouplist=$qb['Sportsgroup']->getQuery()->getResult();
     $trainerdependentlist=[];
     
     foreach ($phonenumberlist as $pn)
     {
      $trainerdependentlist[$pn->getTrainerid()]['phonenumbers'][]=$pn;
     }
     
     foreach ($licencelist as $lc)
     {
      $trainerdependentlist[$lc->getTrainerid()]['licences'][]=$lc;
     }

     foreach ($focuslist as $fc)
     {
      $trainerdependentlist[$fc->getTrainerid()]['focuses'][]=$fc;
     }
     
     foreach ($sportsgrouplist as $sp)
     {
      $trainerdependentlist[$sp->getTrainerid()]['sportsgroup'][$sp->getType()][]=$sp;
     }

     return $this->render('Trainer/trainer.html.twig',
                   array('tabledata'=>$trainerlist,
                         'colorclass'=>"bluetheader",
                         'searchform'=>$searchform->createView(),
                         'trainerdependentlist' => $trainerdependentlist,         
                         'cletter'=>$letter,
                         'path'=>'trainer_home'));
    }
//  ------------------------------------------------------------------------------------------------------------------------------
    /**
     * @Route("/trainer/anlegen",name="addtrainer")
     */    
    public function addtrainerAction(Request $request) 
    {        
     $trainer = new Trainer();
     $addtrainerform = $this->createForm(AddTrainerType::class, $trainer);
     $addtrainerform->handleRequest($request);
       
     if ($addtrainerform->isSubmitted() && $addtrainerform->isValid())
     {
      $manager= $this->getDoctrine()->getManager();
      $manager->persist($trainer);
      $manager->flush();  
      $this->addFlash('notice', 'Dieser Übungsleiter wurde erfolgreich angelegt!');
      return $this->redirectToRoute('trainer_home');
     }
        
     return $this->render('Trainer/trainerform.html.twig',
                   array(
                         'form'=>$addtrainerform->createView(),                    
                         'title'=>'Übungsleiter anlegen'
                        ));        
    }
//-------------------------------------------------------------------------------------------------   
    /**
     * @Route("/trainer/bearbeiten/{ID}", name="edittrainer")
     */   
    public function edittrainerAction(Request $request, $ID)
    {
     $doctrine= $this->getDoctrine();
     $manager= $doctrine->getManager();
     $trainer=$doctrine->getRepository('AppBundle:Trainer\Trainer')->findOneBy(array('trainerid' => $ID));
        
     if(!$trainer)
     {
      throw $this->createNotFoundException('Es konnte kein Trainer mit der Trainernr.: '.$ID.' gefunden werden');
     }

     $originallicences = new ArrayCollection();
     $originalphonenr = new ArrayCollection();
     $originalthemes = new ArrayCollection();
        
     foreach($trainer->getTheme() as $th)
     {
      $originalthemes->add($th);
     }
        
     foreach($trainer->getLicence() as $li)
     {
      $originallicences->add($li);
     }
     
     foreach($trainer->getPhonenumber() as $ph)
     {
      $originalphonenr->add($ph);   
     }
        
     $edittrainerform = $this->createForm(EditTrainerType::class, $trainer);
     $edittrainerform -> handleRequest($request);
      
     if($edittrainerform->get('delete')->isClicked())
     {
      $manager->remove($trainer);
      $manager->flush();
      $this->addflash('notice', 'Dieser Übungsleiter wurde erfolgreich gelöscht!');
      return $this->redirectToRoute('trainer_home', array('info' => 'entfernt'));
     }
        
     if($edittrainerform->isSubmitted() && $edittrainerform->isValid())
     {
      foreach($originallicences as $oli)
      {
       if($trainer->getLicence()->contains($oli)==false)
       {
        $manager->remove($oli);
       }  
      }
      foreach($originalphonenr as $oph)
      {
       if($trainer->getPhonenumber()->contains($oph)==false)
       {
        $manager->remove($oph);
       }  
      }
                 
      foreach($originalthemes as $oth)
      {
       if($trainer->getTheme()->contains($oth)==false)
       {
        $manager->remove($oth);
       }  
      }
      $manager->persist($trainer);
      $manager->flush();
      $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');   
      return $this->redirectToRoute('trainer_home');
      }
        
      return $this->render('Trainer/trainerform.html.twig',
      array(            
            'form' => $edittrainerform->createView(),
            'title' => 'Trainer bearbeiten',
            'path'=>'edittrainer',
            'ID'=>$ID,
           ));
    }
}