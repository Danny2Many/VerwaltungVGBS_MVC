<?php

// src/AppBundle/Controller/MemberController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Mitglieder_NichtMitglieder\Member;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Mitglieder\AddMemberType;
use AppBundle\Form\Type\Mitglieder\BaseMemberType;
use AppBundle\Form\Type\Mitglieder\EditMemberType;
use AppBundle\Form\Type\Mitglieder\AdvancedSearchType;
use AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup;
use AppBundle\Entity\Mitglieder_NichtMitglieder\MemPhoneNumber;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ToolsManager;
use DateTime;



class MemberController extends Controller
{
    public $typeSymbolMapper = array('mitglieder' => 'm', 'nichtmitglieder' => 'nm');

    /**
     * @Route("/vgbsverwaltung/{type}/{letter}", defaults={"letter"="A"}, name="member_home", requirements={"type": "mitglieder|nichtmitglieder", "letter": "[A-Z]"})
     */
    public function indexAction(Request $request, $type, $letter)
    {

        if($type=='mitglieder')
        {         
            $idColumnName = 'Mitgliedsnr';
        }
        else
        {           
            $idColumnName = 'NichtMitgliedsnr';
        }
        $doctrine=$this->getDoctrine();

        $qb = $doctrine->getRepository('AppBundle:Mitglieder_NichtMitglieder\Member')->createQueryBuilder('m');
        $qb->where('m.type = \''.$this->typeSymbolMapper[$type].'\'');


        $choices=array(
            'Alte_Nr' => 'lagacymemid',
            $idColumnName   => 'memid',
            'Name' => 'lastname',
            'Vorname' => 'firstname',
            'Strasse' => 'streetaddress',
            'E-Mail' => 'email',
            'Krankenkasse' => 'healthinsurance');
     
 
        $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home', array('type'=>$type))));        
        $searchform->handleRequest($request);
        
    
        //the search
        if($searchform->isSubmitted() && $searchform->isValid())
        {
     
            //setting the letter to null for the pagination not to show any letter
            $letter=null;
     
            //getting the values of the field and column
            $searchval=$request->query->get('search')['searchfield'];
            $searchcol=$request->query->get('search')['column'];

    

                $qb   ->andWhere($qb->expr()->like('m.'.$searchcol, ':searchval'))
                                ->setParameter('searchval','%'.$searchval.'%');
        }
        //if the advancedsearchform was submitted
        elseif ($request->query->has('as'))
        {
            $letter=null;
            $searchingForRehaCert=false;
            $advancedsearchform = $request->query->all();
            $qb     ->leftJoin('m.sportsgroup', 'ms');
            
            if(isset($advancedsearchform['terminationdatecompoperators']))
            {
                $qb->leftJoin('m.rehabilitationcertificate', 'mr');
                $searchingForRehaCert=true;
                $tdtime = strtotime($advancedsearchform['terminationdate']);
                $convertedTerminationDate = date('Y-m-d',$tdtime);
                $qb     ->andWhere('mr.terminationdate'.$advancedsearchform['terminationdatecompoperators']. '\''.$convertedTerminationDate.'\'');
            }
            
            if(isset($advancedsearchform['rehabunitscompoperators']))
            {
                if(!$searchingForRehaCert)
                {
                    $qb->leftJoin('m.rehabilitationcertificate', 'mr');
                }
                $qb     ->andWhere('mr.rehabunits'.$advancedsearchform['rehabunitscompoperators'].$advancedsearchform['rehabunits']);
            }
            
        }
        else
        {
            $qb   ->andWhere($qb->expr()->like('m.lastname',':letter' ))
                            ->setParameter('letter',$letter.'%');
     
            switch($letter)
            {
                case 'A': $qb ->andWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                                        ->setParameter('umlautletter','Ä%');
                break;
        
                case 'O': $qb ->andWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                                        ->setParameter('umlautletter','Ö%');
                break;
        
                case 'U': $qb ->andWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                                        ->setParameter('umlautletter','Ü%');
                break;
            } 
        
        
        }
  
        $memberdata=$qb->getQuery()->getResult();

 

        return $this->render(
        'Mitglieder_Nichtmitglieder/member.html.twig',
        array(
            'tabledata' => $memberdata,
            'type' => $type,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'cletter' => $letter,
            'path' => $this->generateUrl('member_home', array('type'=>$type))     
            ));
    }
  
    
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * @Route("/vgbsverwaltung/{type}/anlegen/{letter}", defaults={"letter": "A"}, name="addmem", requirements={"type": "mitglieder|nichtmitglieder", "letter": "[A-Z]"})
     * 
     */
    public function addmemberAction(Request $request, $type, $letter)
    {
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        $m_sg= new Member_Sportsgroup();
        $typeSymbol=$this->typeSymbolMapper[$type];
              
        $member->addPhonenumber($phonenumber);               
        $member->addSportsgroup($m_sg);
        if($type == 'mitglieder')
        {
            $formType = AddMemberType::class;
            $titel = 'Mitglied anlegen';
        }
        else
        {
            $formType = BaseMemberType::class;
            $titel = 'Nichtmitglied anlegen';
        }
        
        $addmemform = $this->createForm($formType, $member, array('typeSymbol'=> $typeSymbol));
        $addmemform->handleRequest($request);
     
    
        //if the form is valid -> persist it to the database
        if($addmemform->isSubmitted() && $addmemform->isValid())
        {
            $member->setType($typeSymbol);
            $manager->persist($member);      
            $manager->flush();
            
            $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!'); 
            return $this->redirectToRoute('member_home', array('type'=>$type, 'letter' => $letter));    
        }
        

        return $this->render(
        'Mitglieder_NichtMitglieder/memberform.html.twig',
        array(
            'form' => $addmemform->createView(),
            'cletter' => $letter,
            'title' => $titel,
            'type'=>$type
            
            ));
    }
    
    
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 
    
    /**
     * @Route("/vgbsverwaltung/{type}/bearbeiten/{letter}/{ID}", defaults={"type": "mitglieder", "letter": "A"}, requirements={"type": "mitglieder|nichtmitglieder", "letter": "[A-Z]"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $ID, $type, $letter)
    {
        if($type == 'mitglieder')
        {
            $titel = 'Mitglied bearbeiten';
        }else
        {
            $titel = 'Nichtmitglied bearbeiten';
        }
    
 
        $doctrine=$this->getDoctrine(); 
        $manager= $doctrine->getManager();
        $tm = new ToolsManager($manager);

        $member=$doctrine->getRepository('AppBundle:Mitglieder_NichtMitglieder\Member')->findOneBy(array('memid'=>$ID));
   
        
        if (!$member)
        {
            throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
        }
   
        $originalrehabs = $tm->copyArrayCollection($member->getRehabilitationcertificate());
        $originalphonenrs = $tm->copyArrayCollection($member->getPhonenumber());
        $originalsportsgroups = $tm->copyArrayCollection($member->getSportsgroup());
  
        $editmemform = $this->createForm(EditMemberType::class, $member, array('typeSymbol' => $this->typeSymbolMapper[$type]));
        $editmemform->handleRequest($request);
          
        if($editmemform->get('delete')->isClicked())
        {
            $manager->remove($member);
            $manager->flush();

            $this->addFlash('notice', 'Diese Person wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('member_home', array('type'=>$type, 'letter' => $letter));
        }
 
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid())
        {      
            $tm->sortOutRemoved($originalrehabs, $member->getRehabilitationcertificate());
            $tm->sortOutRemoved($originalphonenrs, $member->getPhonenumber());
            $tm->sortOutRemoved($originalsportsgroups, $member->getSportsgroup());
      
            $manager->persist($member);
            $manager->flush();
                        
            $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');  
            return $this->redirectToRoute('member_home', array('type' => $type, 'letter' => $letter));  
        }
        
        
        return $this->render(
            'Mitglieder_Nichtmitglieder/memberform.html.twig',
            array(
            
            'form' => $editmemform->createView(),
            'cletter' => $letter,
            'type' => $type,
            'title' => $titel
            ));
    }
    
    /**
     * @Route("/vgbsverwaltung/{type}/erweitertesuche/{letter}", defaults={"letter"="A"}, name="advancedsearchmem", requirements={"type": "mitglieder|nichtmitglieder", "letter": "[A-Z]"})
     */
    public function advancedSearchAction(Request $request, $type, $letter)
    {

        $advancedsearch = new \AppBundle\Entity\Mitglieder_NichtMitglieder\advancedsearch();
        
        if($request->query->has('as'))
        {
            $advancedsearch->setTerminationdatecompoperators($request->query->get('terminationdatecompoperators'));           
            //convert the terminationdate from a string to a DateTime-Object
            $terminationdate = DateTime::createFromFormat('d.m.Y', $request->query->get('terminationdate'));
            $advancedsearch->setTerminationdate($terminationdate); 
            $advancedsearch->setRehabunitscompoperators($request->query->get('rehabunitscompoperators'));
            $advancedsearch->setRehabunits($request->query->get('rehabunits'));
        }
        
        
        $advancedsearchform = $this->createForm(AdvancedSearchType::class, $advancedsearch, array('typeSymbol' => $this->typeSymbolMapper[$type]));
        
        $advancedsearchform->handleRequest($request);

 
        if ($advancedsearchform->isSubmitted() && $advancedsearchform->isValid())
        {
            //entfernen von leeren Einträgen (nicht ausgefüllten Feldern)
            $advancedsearchform= array_filter($request->request->get('advanced_search'));
            
            if(isset($advancedsearchform['terminationdatecompoperators']))
            {
                $advancedsearchform['terminationdate']=$advancedsearch->getTerminationdate()->format('d.m.Y');
                
            }    
            
//            $this->addFlash('search', 'Gesucht werden Personen mit: '.$flashtext);
            return  $this->redirectToRoute('member_home', array_merge(array('type'=>$type, 'letter' => $letter, 'as' => ''), $advancedsearchform));
        }
        
        return $this->render(
            'Mitglieder_Nichtmitglieder/advancedsearchform.html.twig',
            array(           
            'form' => $advancedsearchform->createView(),
            'cletter' => $letter,
            'type' => $type,
            'title' => 'Erweiterte Suche'
            ));

    }
}


