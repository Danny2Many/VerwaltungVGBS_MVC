<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Location\AddLocationType;
use AppBundle\Form\Type\Location\EditLocationType;
use AppBundle\Entity\Location;
use Doctrine\Common\Collections\ArrayCollection;

class LocationController extends Controller {
    /**
     * @Route("/räume/{letter}", defaults={"letter"="alle"}, name="location_home", requirements={"letter": "[A-Z]|alle"})
     */
    public function indexAction(Request $request,$letter) 
    {
       $doctrine = $this->getDoctrine();
       $dependencies=['Location','Room'];
       $qb=[];
            
            foreach($dependencies as $dependent)
            { 
             $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            }
            
            $qb['Location']->add('select','ditto')
                           ->add('from','AppBundle\Entity\Location ditto');
           
        //searchoptions for the searchfield
            $choices=array('Standortname'=>'locname',
                           'Straße,Hnr.'=>'streetaddress',
                           'PLZ'=>'postcode',
                          );
            
        //searchfield implementation   
            $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('location_home')));
            $searchform->handleRequest($request);
            
            if($searchform->isSubmitted() && $searchform->isValid())
            {
             $searchval=$request->query->get('search')['searchfield'];
             $searchcol=$request->query->get('search')['column'];
        
        
                 $qb['Location']->andWhere($qb['Location']->expr()->like('ditto.'.$searchcol,':location'))
                                 ->setParameter('location','%'.$searchval.'%')
                                 ->getQuery();
             }
        
            elseif($letter!='alle')
            {
             $qb['Location']->andWhere($qb['Location']->expr()->like('ditto.locname', ':letter'))
                                                              ->setParameter('letter',$letter.'%');
             switch($letter)
             {
              case 'A': $qb['Location']->orWhere($qb['Location']->expr()->like('ditto.locname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ä%'); 
              break;

              case 'O': $qb['Location']->orWhere($qb['Location']->expr()->like('ditto.locname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ö%'); 
              break;

              case 'U': $qb['Location']->orWhere($qb['Location']->expr()->like('ditto.locname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ü%'); 
              break;  
             }
            }
            else
            {
             $letter=null;
            }
            
            $locationlist=$qb['Location']->getQuery()->getResult();
            $roomlist=$qb['Room']->getQuery()->getResult();

            $locationdependentlist=[];
                
                       
             foreach($roomlist as $room)
                {
                 $locationdependentlist[$room->getLocID()]['room'][]=$room;
                }   
                
            return $this->render('Location/location.html.twig',
                    array('tabledata'=>$locationlist,
                    'colorclass'=>"bluetheader",
                    'searchform'=>$searchform->createView(),
                    'locationdependentlist' => $locationdependentlist,         
                    'path'=>'location_home',
                    'cletter'=>$letter,
                    )); 
    }
    
    /**
     * @Route("/räume/anlegen", name="addloc")
     */
    public function addlocationAction(Request $request)
    {
     $location=new Location();
     $addlocform = $this->createForm(AddLocationType::class, $location);
     $addlocform->handleRequest($request);  

     if($addlocform->isSubmitted() && $addlocform->isValid())
        {
         $manager= $this->getDoctrine()->getManager();
         $manager->persist($location);
         $manager->flush();
         $this->addFlash('notice', 'Dieser Standort wurde erfolgreich angelegt!'); 
         return $this->redirectToRoute('location_home');
        }
        
     return $this->render('Location/locationform.html.twig',
        array('form' => $addlocform->createView(),
              'title' => 'Standort anlegen',
             )
        );   
    }
    
    /**
     * @Route("/räume/bearbeiten/{ID}", name="editloc")
     */
    public function editlocationAction(Request $request,$ID)
    {
     $doctrine=$this->getDoctrine(); 
     $manager= $doctrine->getManager();
     $location=$manager->getRepository('AppBundle:Location')->findOneBy(array('locid'=>$ID));
            
            if (!$location) 
            {
             throw $this->createNotFoundException('Es konnte kein Standort mit der Standortnr.: '.$ID.' gefunden werden');
            }
                
            $editlocform = $this->createForm(EditLocationType::class, $location);
            $editlocform->handleRequest($request);
            
            if($editlocform->get('delete')->isClicked())
            {
             $manager->remove($location);
             $manager->flush();
             return $this->redirectToRoute('location_home', array('info' => 'entfernt'));
            }
            //if save button is pressed and all inputs are valid, persist the data into the database
            if($editlocform->isSubmitted() && $editlocform->isValid())
            {
             $manager->persist($location);
             $manager->flush();
             $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');   
             return $this->redirectToRoute('location_home');
            }
        
            return $this->render('Location/locationform.html.twig',array('form' => $editlocform->createView(),'title' => 'Standort bearbeiten'));
            } 
    }
    

