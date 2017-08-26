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


//The controller which controlls all member and nonmember (member+nonmember=(non)member) related actions
class MemberController extends Controller
{
    //Mapps the type of a (non)member to its corresponding typeSymbol
    //The typesymbol is the discriminator between member and nonmember in the database
    public $typeSymbolMapper = array('mitglieder' => 'm', 'nichtmitglieder' => 'nm');

    
    //indexAction handles all logic of the main (non)member page
    //Route-Parameters:
    //  type = the type of a (non)member (nonmember or member)
    //  relation = if registered or quitted (non)members
    //  letter = the initial letter of surname of the searched (non)members
    /**
     * @Route("/vgbsverwaltung/{type}/{relation}/{letter}", defaults={"letter"="A"}, name="member_home", requirements={"type": "mitglieder|nichtmitglieder", "relation": "eingeschrieben|ausgetreten", "letter": "[A-Z]"})
     */
    public function indexAction(Request $request, $type, $relation, $letter)
    {
        //Set the ID-names for the searchform
        $idColumnName = 'Mitgliedsnr';
        if($type=='nichtmitglieder')
        {         
            $idColumnName = 'Nicht'.$idColumnName;
        }
        
        //Query for the (non)members - the typesymbol decides whether you query for nonmember or member
        $doctrine=$this->getDoctrine();
        $qb = $doctrine->getRepository('AppBundle:Mitglieder_NichtMitglieder\Member')->createQueryBuilder('m');
        $qb->where('m.type = \''.$this->typeSymbolMapper[$type].'\'');
        
        //Add an additional constraint to filter out member who are not registered anymore if $relation == 'eingeschrieben'
        //(member whose quitdate is younger than the current date or null)
        if($relation == 'eingeschrieben')
        {
            $qb->andWhere('m.quitdate >= '.date('Y-m-d').' OR m.quitdate is null');
        }
        //Add an additional constraint to the query to filter out member who are still registered if $relation == 'ausgetreten'
        //(member whose quitdate is older than the current date)
        else
        {
            $qb->andWhere('m.quitdate <= '.date('Y-m-d'));
        }

        //Initialize the array for the searchform searchcolumns
        $choices=array(
            'Alte_Nr' => 'lagacymemid',
            $idColumnName   => 'memid',
            'Name' => 'lastname',
            'Vorname' => 'firstname',
            'Strasse' => 'streetaddress',
            'E-Mail' => 'email',
            'Krankenkasse' => 'healthinsurance');
     
        //Initialize the searchform: 
        //The form for searching in the memberstable via a user specified column (a property of a member) and a search term
        $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_home', array('type'=>$type, 'relation'=>$relation))));        
        $searchform->handleRequest($request);
        
    
        //If the searchform was submitted and is valid
        if($searchform->isSubmitted() && $searchform->isValid())
        {
     
            //Setting the variable letter to null for the pagination not to show any letter
            $letter=null;
     
            //getting the values of the searchfield (the searchterm) and column (the property of the member to be searched)
            $searchval=$request->query->get('search')['searchfield'];
            $searchcol=$request->query->get('search')['column'];

    
            //Adding the searchparameters as constraint of the (non)member query
            $qb   ->andWhere($qb->expr()->like('m.'.$searchcol, ':searchval'))
                                ->setParameter('searchval','%'.$searchval.'%');
        }
        //If the parameter "as" is defined in the URL: If the advancedsearchform was submitted
        elseif ($request->query->has('as'))
        {
            //Setting the variable letter to null for the pagination not to show any letter
            $letter=null;
            //A variable to check if the user is searching for rehabcert related searchparameters
            $searchingForRehaCert=false;
            //Get all submitted searchparameters of the advancedsearchform
            $advancedsearchform = $request->query->all();

            //If the terminationdatecompoperators field was submitted:
            //This means that the user is searching for a member with a rehabcert which has a specific terminationdate
            //(The advancedsearchform ensures that if one field (terminationdatecompoperators or terminationdate) 
            //was filled by the user the other field must be filled too)
            if(isset($advancedsearchform['terminationdatecompoperators']))
            {
                //Join the MemRehabilitationCertificate table with the NonAndMember table
                $qb->leftJoin('m.rehabilitationcertificate', 'mr');
                //The user is searching for rehabcert related searchparameters
                $searchingForRehaCert=true;
                
                //Convert the user specified terminationdate in two steps from the dateformat dd.mm.YY to Y-m-d 
                //to use it in a query constraint:
                //First: Convert it to miliseconds
                $tdtime = strtotime($advancedsearchform['terminationdate']);
                //Second: Convert those miliseconds to the dateformat Y-m-d
                $convertedTerminationDate = date('Y-m-d',$tdtime);
                
                $qb     ->andWhere('mr.terminationdate'.$advancedsearchform['terminationdatecompoperators']. '\''.$convertedTerminationDate.'\'');
            }
            
            //If the rehabunitscompoperators field was submitted:
            //This means that the user is searching for a member with a rehabcert which has a specific number of units left
            //(The advancedsearchform ensures that if one field (rehabunitscompoperators or rehabunits) 
            //was filled by the user the other field must be filled too)
            if(isset($advancedsearchform['rehabunitscompoperators']))
            {
                //If no terminationdate searchparameters were added
                if(!$searchingForRehaCert)
                {
                    $qb->leftJoin('m.rehabilitationcertificate', 'mr');
                }
                $qb     ->andWhere('mr.rehabunits'.$advancedsearchform['rehabunitscompoperators'].$advancedsearchform['rehabunits']);
            }
            
            //If the membersportsgroupstate field was submitted:
            //This means that the user is searching for a member who was/is registered in a specific sportsgroup
            //(The advancedsearchform ensures that if one field (membersportsgroupstate or sportsgroup) 
            //was filled by the user the other field must be filled too)
            if(isset($advancedsearchform['membersportsgroupstate']))
            {
                //Join the Sportsgroup table with the NonAndMember table
                $qb     ->leftJoin('m.sportsgroup', 'ms');
                $qb     ->leftJoin('ms.sportsgroup', 'mss');
                $qb     ->andWhere('mss.sgid='.$advancedsearchform['sportsgroup']['id']);
                $qb     ->andWhere('ms.resignedfrom '.$advancedsearchform['membersportsgroupstate'].' null');

            }
            
        }
        //If neither the searchform nor the advancedsearchform was submitted
        else
        {
            //Filter (non)member by their surname intials
            $qb   ->andWhere($qb->expr()->like('m.lastname',':letter' ))
                            ->setParameter('letter',$letter.'%');
            
            //(non)member with umlauts are included in their corresponding nonumlaut letter 
            //(e.g. a (non)member whose surname begins with "Ä" is displayed amongs all (non)member beginning with "A")
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
        //Get the result of the build query
        $memberdata=$qb->getQuery()->getResult();

        //Render the view
        return $this->render(
        'Mitglieder_Nichtmitglieder/member.html.twig',
        array(
            'tabledata' => $memberdata, //the query result
            'colorclass' => "bluetheader", //Determines the color of the table header
            'searchform' => $searchform->createView(),//the searchform
            'pathname' => 'member_home', //the name of the path
            'pathparameters' => array('type'=>$type, 'relation' =>$relation, 'letter' => $letter)//The parameters of the memberpath     
            ));
    }
  
    
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    
    
    //addmemberAction handles all logic of the form where the user is able to add an (non)member to the database
    //Route-Parameters:
    //  type = the type of a (non)member (nonmember or member) to add
    //  letter = the initial letter of surname of the searched (non)members on the main page where the user pushed the add member button
    /**
     * @Route("/vgbsverwaltung/{type}/anlegen/{letter}", defaults={"letter": "A"}, name="addmem", requirements={"type": "mitglieder|nichtmitglieder", "letter": "[A-Z]"})
     * 
     */
    public function addmemberAction(Request $request, $type, $letter)
    {
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        
        //initialize new Member, MemPhoneNumber, Member_Sportsgroup objects to fill these with user specified data of
        //the addmemberform and persist them at last to the database
        $member = new Member();
        $phonenumber = new MemPhoneNumber();
        $m_sg= new Member_Sportsgroup();
        
        $typeSymbol=$this->typeSymbolMapper[$type];
         
        //add the empty MemPhoneNumber and Member_Sportsgroup objects to the member object 
        //to display the corresponding formfields in the form
        $member->addPhonenumber($phonenumber);               
        $member->addSportsgroup($m_sg);
        
        //if the user intends to add a new member to the db choose AddMemberType as class for the addmemberform 
        //and 'Mitglied anlegen' as titel of the page else BaseMemberType and 'Nichtmitglied anlegen'
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
            //Set the typeSymbol to decide whether this new (non)member is a member or a nonmember
            $member->setType($typeSymbol);
            $manager->persist($member);      
            $manager->flush();
            
            $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!'); 
            return $this->redirectToRoute('member_home', array('type'=>$type, 'relation' => 'eingeschrieben', 'letter' => $letter));    
        }
        

        return $this->render(
        'Mitglieder_NichtMitglieder/memberform.html.twig',
        array(
            'form' => $addmemform->createView(), //the addmemberform
            'title' => $titel, //the titel of the page            
            'pathparameters' => array('type' => $type, 'relation' => 'eingeschrieben', 'letter' => $letter,) //The parameters of the route
            
            ));
    }
    
    
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 
    
    
    
    //editmemberAction handles all logic of the form where the user is able to edit the data of a (non)member
    //Route-Parameters:
    //  type = the type of a (non)member (nonmember or member)
    //  relation = if registered or quitted (non)member
    //  letter = the initial letter of surname of the searched (non)members
    //  ID = ID of the (non)member to edit
    /**
     * @Route("/vgbsverwaltung/{type}/{relation}/bearbeiten/{letter}/{ID}", defaults={"type": "mitglieder", "letter": "A"}, requirements={"type": "mitglieder|nichtmitglieder", "relation": "eingeschrieben|ausgetreten","letter": "[A-Z]"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $ID, $type, $relation, $letter)
    {
        
        //if the user edits a member the titel of the page is 'mitglieder' else 'Nichtmitglied bearbeiten'
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
        
        //query for the (non)member to edit by id
        $member=$doctrine->getRepository('AppBundle:Mitglieder_NichtMitglieder\Member')->findOneBy(array('memid'=>$ID));
   
        //if no member with the specified id was found 
        if (!$member)
        {
            throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
        }
        
        //duplicate all related Rehabilitationcertificate, Phonenumber, Sportsgroup objects of the (non)member
        //in dedicated ArrayCollections to further controll if related objects has been added or deleted
        $originalrehabs = $tm->copyArrayCollection($member->getRehabilitationcertificate());
        $originalphonenrs = $tm->copyArrayCollection($member->getPhonenumber());
        $originalsportsgroups = $tm->copyArrayCollection($member->getSportsgroup());
  
        $editmemform = $this->createForm(EditMemberType::class, $member, array('typeSymbol' => $this->typeSymbolMapper[$type]));
        $editmemform->handleRequest($request);
         
        //if the user clicks the delete button to delete the (non)member
        if($editmemform->get('delete')->isClicked())
        {
            $manager->remove($member);
            $manager->flush();

            $this->addFlash('notice', 'Diese Person wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('member_home', array('type'=>$type, 'relation' => $relation, 'letter' => $letter));
        }
 
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid())
        {      
            //sort out removed related objects
            $tm->sortOutRemoved($originalrehabs, $member->getRehabilitationcertificate());
            $tm->sortOutRemoved($originalphonenrs, $member->getPhonenumber());
            $tm->sortOutRemoved($originalsportsgroups, $member->getSportsgroup());
      
            $manager->persist($member);
            $manager->flush();
                        
            $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');  
            return $this->redirectToRoute('member_home', array('type' => $type, 'relation' => $relation, 'letter' => $letter));  
        }
        
        
        return $this->render(
            'Mitglieder_Nichtmitglieder/memberform.html.twig',
            array(            
            'form' => $editmemform->createView(), //the editmemberform
            'title' => $titel, //the titel of the page
            'pathparameters' => array('type'=>$type, 'relation' =>$relation, 'letter' => $letter)//The parameters of the memberpath     

            ));
    }
    
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 

    //advancedSearchAction handles all logic of the form where the user is able to do a advanced search
    //Route-Parameters:
    //  type = the type of a (non)member (nonmember or member)
    //  relation = if registered or quitted (non)member
    //  letter = the initial letter of surname of the searched (non)members
    /**
     * @Route("/vgbsverwaltung/{type}/{relation}/erweitertesuche/{letter}", defaults={"letter"="A"}, name="advancedsearchmem", requirements={"type": "mitglieder|nichtmitglieder","relation": "eingeschrieben|ausgetreten", "letter": "[A-Z]"})
     */
    public function advancedSearchAction(Request $request, $type, $relation, $letter)
    {
        //initialize advancedsearch object which controlls the evaluation of the advancedsearchform
        $advancedsearch = new \AppBundle\Entity\Mitglieder_NichtMitglieder\advancedsearch($relation);
        
        
        //if the user wants to change the searchcriterea: add all specified searchparameter from the url to the
        //advancedsearch to display them in the form
        if($request->query->has('as'))
        {
            if($request->query->has('terminationdatecompoperators'))
            {
                $advancedsearch->setTerminationdatecompoperators($request->query->get('terminationdatecompoperators'));           
                //convert the terminationdate from a string to a DateTime-Object
                $terminationdate = DateTime::createFromFormat('d.m.Y', $request->query->get('terminationdate'));
                $advancedsearch->setTerminationdate($terminationdate); 
            }
            
            if($request->query->has('rehabunitscompoperators'))
            {
                $advancedsearch->setRehabunitscompoperators($request->query->get('rehabunitscompoperators'));
                $advancedsearch->setRehabunits($request->query->get('rehabunits'));
            }
            
            if($request->query->has('membersportsgroupstate'))
            {
            //Query for the Sportsgroup
            $doctrine=$this->getDoctrine();
            $sportsgroup=$doctrine->getRepository('AppBundle:Sportsgroup')->findOneBy(array('sgid'=>$request->query->get('sportsgroup')['id']));
            $advancedsearch->setSportsgroup($sportsgroup);
            
            //if $relation == 'ausgetreten' the user is only able to search for (non)member who resigned from a sportsgroup
            if($relation != 'ausgetreten')
            {
                $advancedsearch->setMembersportsgroupstate($request->query->get('membersportsgroupstate'));
            }
            
            }
        }

 
        $advancedsearchform = $this->createForm(AdvancedSearchType::class, $advancedsearch, array('typeSymbol' => $this->typeSymbolMapper[$type], 'relation' => $relation));
        
        $advancedsearchform->handleRequest($request);

 
        if ($advancedsearchform->isSubmitted() && $advancedsearchform->isValid())
        {

            
            //returns true if the value of a field is not empty to transfer this value to the url as parameter
            $filterCallbackFunction = function ($value){
                if(is_array($value)) $value= array_filter($value);
                if(empty($value)) return false;
                return true;
            };
            
            //removing of empty formfields
            $advancedsearchform= array_filter($request->request->get('advanced_search'), $filterCallbackFunction);
            
            
            if(isset($advancedsearchform['terminationdatecompoperators']))
            {
                //convert the terminationdate to a german format to display it on the (non)member page 
                //in a way the user is able to understand easily 
                $advancedsearchform['terminationdate']=$advancedsearch->getTerminationdate()->format('d.m.Y');
                
            }
            
            if(isset($advancedsearchform['sportsgroup']))
            {
                if ($relation == 'ausgetreten')
                {
                    //If $relation == 'ausgetreten' the membersportsgroupstate-Field is will not be submitted.
                    //Because this fact the value has to be set artificially when the advanced search has been start from the resigned list
                    $advancedsearchform['membersportsgroupstate'] = 'is not';

                }
                
                //Additionally to the id of a sportsgroup, add its token to the form array, to display it on the main page
                $advancedsearchform['sportsgroup'] = array(
                    'id'=>$advancedsearch->getSportsgroup()->getSgid(),
                    'name' => $advancedsearch->getSportsgroup()->getToken());
            }

            return  $this->redirectToRoute('member_home', array_merge(array('type'=>$type, 'relation'=>$relation, 'letter' => $letter, 'as' => ''), $advancedsearchform));
        }
        
        return $this->render(
            'Mitglieder_Nichtmitglieder/advancedsearchform.html.twig',
            array(           
            'form' => $advancedsearchform->createView(), //the advancedsearchform
            'pathparameters' => array('type'=>$type, 'relation' =>$relation, 'letter' => $letter),//The parameters of the memberpath     
            'title' => 'Erweiterte Suche' //the title of the page
            ));

    }

}


