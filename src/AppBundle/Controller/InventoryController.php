<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SearchType;
use AppBundle\Form\Type\Inventory\AddObjectType;
use AppBundle\Form\Type\Inventory\EditObjectType;
use AppBundle\Entity\Inventory\Inventory;
use Doctrine\Common\Collections\ArrayCollection;

class InventoryController extends Controller 
{
    /**
     * @Route("/inventar/{currroom}/{state}/{letter}", defaults={"currroom"="alle","state"="alle","letter"="alle"}, name="inventory_home", requirements={"currroom": "[0-9]+|alle","letter": "[A-Z]|alle"})
     */
    
   public function indexAction(Request $request, $currroom, $state, $letter)
           {
            $doctrine = $this->getDoctrine();
            $dependencies=['Inventory\Inventory','Inventory\ObjectOrder','Inventory\Stocktaking'];
            $qb=[];
            $qb['Room'] = $doctrine->getRepository('AppBundle\Entity\Room')->createQueryBuilder('ditto');
            
            foreach($dependencies as $dependent)
            { 
             $qb[$dependent] = $doctrine->getRepository('AppBundle:'.$dependent)->createQueryBuilder('ditto');
            }
            
            $qb['Inventory\Inventory']->add('select','ditto')
                                      ->add('from','AppBundle\Entity\Inventory\Inventory ditto');
           
        //dropdown filter
        //location
            if($currroom!="alle")
                {
                 $qb['Inventory\Inventory']->leftJoin('ditto.stocktaking', 'si')
                                           ->leftJoin('si.location','sil')
                                           ->andWhere('sil.roomid=:currroom')
                                           ->setParameter('currroom',$currroom);
                }
                
        //state of the object    
            if($state!="alle")
                {
                 $qb['Inventory\Inventory']->leftJoin('ditto.stocktaking', 'st')
                                           ->andWhere('st.state=:state')
                                           ->setParameter('state',$state);
                }
                
        //searchoptions for the searchfield
            $choices=array('Inventarnr.'=>'invid',
                           'Bezeichnung'=>'objectname',
                           'Anschaffungsjahr'=>'orderdate',
                          );
            
        //searchfield implementation   
            $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('inventory_home')));
            $searchform->handleRequest($request);
            
            if($searchform->isSubmitted() && $searchform->isValid())
            {
             $searchval=$request->query->get('search')['searchfield'];
             $searchcol=$request->query->get('search')['column'];
        
        //search option orderdate         
             if($searchcol=='orderdate')
             {
              $objectorderqb= clone $qb['Inventory\ObjectOrder'];
              $objectorderqb->andWhere($objectorderqb->expr()->like('ditto.'.$searchcol,':type'))
                                                             ->setParameter('type','%'.$searchval.'%');
              $objectorderlist=$objectorderqb->getQuery()->getResult();
               
                if($objectorderlist)
                {
                    foreach ($objectorderlist as $oo)
                    {         
                     $idarray[]=$oo->getInvid();     
                    }
                }
                else
                {
                     $idarray=array(null);  
                }

             $qb['Inventory\Inventory']->andWhere($qb['Inventory\Inventory']->expr()->in('ditto.invid', $idarray));
             }
        
        //search options Inv-ID, Objectname     
            else{
                 $qb['Inventory\Inventory']->andWhere($qb['Inventory\Inventory']->expr()->like('ditto.'.$searchcol,':inventory'))
                                 ->setParameter('inventory','%'.$searchval.'%')
                                 ->getQuery();
                }
            }
            
        //filter with letters
        //in case there is an Umlaut include the searchresults within the corresponding letter (ä->a,ö->o,ü->u)
            elseif($letter!='alle')
            {
             $qb['Inventory\Inventory']->andWhere($qb['Inventory\Inventory']->expr()->like('ditto.objectname', ':letter'))
                                                                            ->setParameter('letter',$letter.'%');
             switch($letter)
             {
              case 'A': $qb['Inventory\Inventory']->orWhere($qb['Inventory\Inventory']->expr()->like('ditto.objectname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ä%'); 
              break;

              case 'O': $qb['Inventory\Inventory']->orWhere($qb['Inventory\Inventory']->expr()->like('ditto.objectname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ö%'); 
              break;

              case 'U': $qb['Inventory\Inventory']->orWhere($qb['Inventory\Inventory']->expr()->like('ditto.objectname', ':umlautletter'))
                                                  ->setParameter('umlautletter','Ü%'); 
              break;   
             }
            }
            else
            {
             $letter=null;
            }
            
            $inventorylist=$qb['Inventory\Inventory']->getQuery()->getResult();
            $orderlist=$qb['Inventory\ObjectOrder']->getQuery()->getResult();
            $stocktakinglist=$qb['Inventory\Stocktaking']->getQuery()->getResult();
            $roomlist=$qb['Room']->getQuery()->getResult();
            $currroomname="alle";
            
            foreach($roomlist as $room)
                {
                 if($room->getRoomID()==$currroom)
                         {
                          $currroomname=$room->getRoomname();
                         }
                }

            $inventorydependentlist=[];
            
            foreach($orderlist as $order)
                {
                 $inventorydependentlist[$order->getInvid()]['order'][]=$order;
                }
                
            foreach($stocktakinglist as $stocktaking)
                {
                 $inventorydependentlist[$stocktaking->getInvid()]['stocktaking'][]=$stocktaking;
                }
            
            return $this->render('Inventory/inventory.html.twig',
                    array('tabledata'=>$inventorylist,
                    'colorclass'=>"bluetheader",
                    'searchform'=>$searchform->createView(),
                    'inventorydependentlist' => $inventorydependentlist,         
                    'cletter'=>$letter,
                    'path'=>'inventory_home',
                    'roomlist'=>$roomlist,
                    'currroom'=>$currroom,
                    'currroomname'=>$currroomname,
                    'state'=>$state,
                    ));
           }       
    /**
     * @Route("/inventar/anlegen", name="addobj")
     */
    
    //adding an object to the database
   public function addobjectAction(Request $request)
    {
     $object=new Inventory();
     $addobjform = $this->createForm(AddObjectType::class, $object);
     $addobjform->handleRequest($request);  

     if($addobjform->isSubmitted() && $addobjform->isValid())
        {
         $manager= $this->getDoctrine()->getManager();
         $manager->persist($object);
         $manager->flush();
         $this->addFlash('notice', 'Dieses Objekt wurde erfolgreich angelegt!'); 
         return $this->redirectToRoute('inventory_home');
        }
        
     return $this->render('Inventory/inventoryform.html.twig',
        array('form' => $addobjform->createView(),
              'title' => 'Objekt anlegen',
             )
        );
    }
   
    /**
     * @Route("/inventar/bearbeiten/{ID}",name="editobj")
     */
    
    //edit an object from the database
   public function editobjectAction(Request $request,$ID)
           {
            $doctrine=$this->getDoctrine(); 
            $manager= $doctrine->getManager();
            $object=$manager->getRepository('AppBundle:Inventory\Inventory')->findOneBy(array('invid'=>$ID));
            //throw an exception if the object doesn't exist
            //only happens when the object ID is entered directly in the URL
            if (!$object) 
            {
             throw $this->createNotFoundException('Es konnte kein Objekt mit der Inventarnr.: '.$ID.' gefunden werden');
            }
            
            $originalobjectorder=new ArrayCollection();
            $originalstocktaking=new ArrayCollection();
            
            foreach($object->getOrder()as $ord)
                {
                 $originalobjectorder->add($ord);
                }
            
             foreach($object->getStocktaking()as $st)
                {
                 $originalstocktaking->add($st);
                }
                
            $editobjform = $this->createForm(EditObjectType::class, $object);
            $editobjform->handleRequest($request);
            
            //delete the current edited object
            if($editobjform->get('delete')->isClicked())
            {
             $manager->remove($object);
             $manager->flush();
             return $this->redirectToRoute('inventory_home', array('info' => 'entfernt'));
            }
            //if save button is pressed and all inputs are valid, persist the data into the database
            if($editobjform->isSubmitted() && $editobjform->isValid())
            {
             foreach($originalobjectorder as $oor)
                 {
                  if($object->getOrder()->contains($oor)==false)
                      {
                        $manager->remove($oor);
                      }  
                 }
             foreach($originalstocktaking as $ost)
                 {
                  if($object->getStocktaking()->contains($ost)==false)
                      {
                        $manager->remove($ost);
                      }  
                 }
             $manager->persist($object);
             $manager->flush();
             $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');   
             return $this->redirectToRoute('inventory_home');
            }
        
            return $this->render('Inventory/inventoryform.html.twig',array('form' => $editobjform->createView(),'title' => 'Objekt bearbeiten'));
            }
}