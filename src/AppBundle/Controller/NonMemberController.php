<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nichtmitglieder\NonMember;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Nichtmitglieder\BaseNonMemberType;
use AppBundle\Form\Type\Nichtmitglieder\EditNonMemberType;
use AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber;
use AppBundle\Services\ToolsManager;




class NonMemberController extends Controller {
    
    /**
     * @Route("/nichtmitglieder/{letter}", defaults={"letter"="A"}, name="nonmember_home", requirements={"letter": "[A-Z]"})

    */    
    public function indexAction (Request $request, $letter) 
    {   

     
        $doctrine = $this->getDoctrine();
        $dependencies=['Nichtmitglieder\NonMember', 'Nichtmitglieder\NonMemPhoneNumber', 
            'Nichtmitglieder\NonMemRehabilitationCertificate'];
        $qb=[];
        foreach($dependencies as $dependent)
        {
            $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
        }
        

    
        $choices=array('Nichtmitgliedsnr.' => 'nmemid',
            'Name' => 'lastname',
            'Vorname' => 'firstname',
            'Straße' => 'streetaddress',
            'E-Mail' => 'email',
            'Sportgruppe' => 'token',
            'RS-Ablaufdatum' => 'terminationdate',
            'Krankenkasse' => 'healthinsurance');
    
        $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 
            'action' => $this->generateUrl('nonmember_home')));
        $searchform->handleRequest($request);
    
        if($searchform->isSubmitted() && $searchform->isValid())
        {
            //setting the letter to null for the pagination not to show any letter
            $letter=null;   
            //getting the values of the field and column
            $searchval=$request->query->get('search')['searchfield'];
            $searchcol=$request->query->get('search')['column'];
    
            if($searchcol=='terminationdate')
            {
                $qb['Nichtmitglieder\NonMemRehabilitationCertificate']
                        ->andWhere($qb['Nichtmitglieder\NonMemRehabilitationCertificate']->expr()->in('ditto.'.$searchcol,':type'))
                        ->setParameter('type','%'.$searchval.'%');

                $rehacelist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();


            
                if($rehacelist)
                {          
                    foreach ($rehacelist as $rc)
                    {         
                        $idarray[]=$rc->getNmemid();     
                    }
                }
                $qb['Nichtmitglieder\NonMember']->andWhere($qb['Nichtmitglieder\NonMember']->expr()->in('ditto.nmemid', $idarray));
            
            }

            else
            {
                $qb['Nichtmitglieder\NonMember']
                        ->andWhere($qb['Nichtmitglieder\NonMember']->expr()->like('ditto.'.$searchcol, ':nonmember'))
                        ->setParameter('nonmember','%'.$searchval.'%');
            } 
        
        }
        else
        {        
        
            $qb['Nichtmitglieder\NonMember']
                    ->andWhere($qb['Nichtmitglieder\NonMember']->expr()->like('ditto.lastname', ':letter'))
                    ->setParameter('letter',$letter.'%');                
        
        
            switch($letter)
            {
              case 'A': $qb['Nichtmitglieder\NonMember']
                        ->andWhere($qb['Nichtmitglieder\NonMember']->expr()->like('ditto.lastname', ':umlautletter'))
                        ->setParameter('umlautletter','Ä%'); 
              break;

              case 'O': $qb['Nichtmitglieder\NonMember']
                        ->andWhere($qb['Nichtmitglieder\NonMember']->expr()->like('ditto.lastname', ':umlautletter'))
                        ->setParameter('umlautletter','Ö%'); 
              break;

              case 'U': $qb['Nichtmitglieder\NonMember']
                        ->andWhere($qb['Nichtmitglieder\NonMember']->expr()->like('ditto.lastname', ':umlautletter'))
                        ->setParameter('umlautletter','Ü%'); 
              break;
            }    
        }    
        //get the builded queries
        $nonmemberlist=$qb['Nichtmitglieder\NonMember']->getQuery()->getResult();
        $phonenumberlist=$qb['Nichtmitglieder\NonMemPhoneNumber']->getQuery()->getResult();
        $rehabcertlist=$qb['Nichtmitglieder\NonMemRehabilitationCertificate']->getQuery()->getResult();
    

        $nonmemberdependentlist=[];

        foreach ($phonenumberlist as $pn)
        {
        $nonmemberdependentlist[$pn->getNMemID()]['phonenumbers'][]=$pn;
        }   

        $now= date('Y-m-d');
        foreach ($rehabcertlist as $rc)
        {
            if($rc->getTerminationdate()->format("Y-m-d") > $now)
            {
                $nonmemberdependentlist[$rc->getNMemID()]['validrehabcerts'][]=$rc;
            }
            else
            {
                $nonmemberdependentlist[$rc->getNMemID()]['expiredrehabcerts'][]=$rc;  
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
            'path' => 'nonmember_home'
            ));
    } 




    
     /**
     * @Route("/nichtmitglieder/anlegen/{letter}", defaults={"letter": "A"}, name="addnonmem", requirements={"letter": "[A-Z]"})
     */
    public function addnonmeberAction(Request $request, $letter)
    {
      
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();

    
        $nonmember = new NonMember ();
        $phonenumber = new NonMemPhoneNumber();   
        $nm_sg= new \AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup();

        $nonmember->addPhonenumber($phonenumber);
        $nonmember->addSportsgroup($nm_sg);
        $addnonmemform = $this->createForm(BaseNonMemberType::class, $nonmember);    

        $addnonmemform->handleRequest($request);     
        
        //if the form is valid -> persist it to the database
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid())
        {
   
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
            'title' => 'Nichtmitglied anlegen',

            ));
        
    }
     /**
     * @Route("/nichtmitglieder/bearbeiten/{letter}/{ID}", defaults={"letter": "A"}, requirements={"letter": "[A-Z]"}, name="editnonmem")
     * 
     */
    public function editnonmeberAction (Request $request, $ID, $letter)
    {
     
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        $tm = new ToolsManager($manager);

        $nonmember=$doctrine->getRepository('AppBundle:Nichtmitglieder\NonMember')->findOneBy(array('nmemid' => $ID));
  
        if (!$nonmember)
        {
            throw $this->createNotFoundException('Es konnte kein Nichtmitglied mit der Nichtmitgliedsnr.: '.$ID.' gefunden werden');
        }
       
        $originalrehabs = $tm->copyArrayCollection($nonmember->getRehabilitationcertificate());
        $originalphonenrs = $tm->copyArrayCollection($nonmember->getPhonenumber());
        $originalsportsgroups = $tm->copyArrayCollection($nonmember->getSportsgroup());
             
        $editnonmemform = $this->createForm(EditNonMemberType::class, $nonmember);
        $editnonmemform->handleRequest($request);
         
        if($editnonmemform->get('delete')->isClicked())
        {   
            $manager->remove($nonmember);
            $manager->flush();
            $this->addflash('notice', 'Dieses Nichtmitglied wurde erfolgreich gelöscht!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter, 'info' => 'entfernt'));
        
        }
           
        //if the form is valid -> persist it to the database
        if($editnonmemform->isSubmitted() && $editnonmemform->isValid())
        { 
            $tm->sortOutRemoved($originalrehabs, $nonmember->getRehabilitationcertificate());
            $tm->sortOutRemoved($originalphonenrs, $nonmember->getPhonenumber());
            $tm->sortOutRemoved($originalsportsgroups, $nonmember->getSportsgroup());

            $manager->flush();
            
            
            $this->addflash('notice', 'Diese Daten wurden erfolgreich gespeichert!');
            return $this->redirectToRoute('nonmember_home', array('letter' => $letter));    
       
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

        

