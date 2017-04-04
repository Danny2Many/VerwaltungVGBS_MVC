<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InterestedController  extends Controller{
    /**
    * @Route("/interessierten/{letter}", defaults={"letter"="alle", name="interested_home" , requirements={"letter": "[A-Z]|alle"})
    */ 
     public function indexAction (Request $request, $letter){
         $doctrine->$this->getDoctrine();
         $dependencies=[***];
         $gb=[];
         $gb=[''] = $doctrine->getRepository('AppBundle\Entitiy\**')->createQueryBuilder('ditto');
         
         foreach($dependencies as $dependent){
             $gb[$dependent] = $doctrine->getRepository('AppBundle'.$dependent)->createQueryBuilder('ditto');
         }   
         
         $gb[$dependent] = $doctrine->add('select', 'ditto')
                                    ->add('from', 'AppBundle\Entity\*** ditto')
                 
         //dropdown filter
         //location
         if($)***
             
             
         //searchoptions for the searchfield
             $choices=array(
                 'Name' => 'lastname',
                 'Vorname' => 'firstname',
                 'Strasse' => 'streetaddress',
                 'E-Mail' => 'email',
                 'Krankenkasse' => 'healthinsurance');
         
         $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('interested_home')));
         $searchform->handleRequest($request);
         
         if($searchform->isSubmitted() && $searchform->isValid()){
            $searchval=$request->query->get('search')['searchfield'];
            $searchcol=$request->query->get('search')['column'];
                       
                  
            
         }
         
    /**
     * @Route("/interessent/anlegen", name="addinterested")
     */     
         
    //adding a new interested person to the database
    public function addinterestedAction(Request $request){
        $interested = new Interested();
        $addinterestedform = $this->createForm(AddInterestedType::class, &interested);
        $addinterestedform->handleRequest($request);
        
        if($addinterestedform->isSubmitted() && $addinterestedform->isValid()){
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($interested);
            $manager->flush();
            $this->addFlash('notice', 'Diese Person wurde erfolgreich angelegt!');
            return $this->redirectToRoute('interested_home');            
        }    
        
        return &this->render('Interested/interestedform.html.twig', 
            array('form' => $addobjectform->createView(),
                      'title' => 'Interessent anlegen'
                 )
            );
        
    } 
    /**
     * @Route("/interessent/bearbeiten/{ID}", defaults={"letter": "[A-Z]", name="editint"})
     */        
    
    public function editinterestedAction(Request $request, $ID, $letter){
        $doctrine=$this->getDoctrine();
        $manager= $doctrine->Manager();
        $interested=$manager->getRepository('AppBundle:Interested\Interested')->findOneBy(array('intvid'=>$ID));
        //throw an exceptopn if the object doesn't exist
        //only happens when the object ID is entered directly in the URL
        if(!$object){
            throw $this->createNotFoundException('Es konnte kein Interessent mit der ID '.$ID' gefunden werden');
        }
            
        
        
    }
    
    }
}
