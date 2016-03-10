<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Nichtmitglieder\Nonmember;
use AppBundle\Form\Type\Nichtmitglieder\AddNonMemberType;
use AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber;
use AppBundle\Entity\Section;

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
        'E-Mail' => 'email');
    
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('nonmember_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
     $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['Spalte'];
    
     
    $query=$qb->where($qb->expr()->like('n.'.$searchcol, ':nonmember'))
                   ->setParameter('nonmember','%'.$searchval.'%')
                   ->getQuery();
    
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
        $query=$query->getQuery()->getResult();
        $nonmemberlist=$query;
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
//        $phonenumber = new NonMemPhoneNumber();
//        $section = new Section ();
//        
//        $nonmember->addSection($section);
//        $nonmember->addPhonenumber($phonenumber);
        
        $addnonmemform = $this->createForm(AddNonMemberType::class, $nonmember);
        $addnonmemform->handleRequest($request);
        
        if($addnonmemform->isSubmitted() && $addnonmemform->isValid()){
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($nonmember);     
            $manager->flush();
            
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
    public function editnonmeberAction (Request $request, $ID, $letter){
        $manager=$this->getDoctrine()->getManager();
        $repository = $this ->getDoctrine()->getRepository('AppBundle\Nichtmitglieder:Nonmember');
        $nonmember=$repository->findOneBy(array('nmemid' => $ID));
    }
}

        

