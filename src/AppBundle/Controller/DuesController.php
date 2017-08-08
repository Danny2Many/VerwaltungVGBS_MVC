<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Beitraege\Dues;
use AppBundle\Form\Type\SearchType;
use AppBundle\Entity\Beitraege\DuesPrice;
use AppBundle\Form\Type\Dues\DuesType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Services\ToolsManager;



class DuesController extends Controller{
    
        /**
     * @Route("/beitraege/{type}/{state}", defaults={"type"="alle", "state"="alle"}, name="dues_home", requirements={"type": "alle|standart|angepasst", "state": "alle|aktuell|veraltet"})
     */
    public function indexAction(Request $request,$type, $state)
    {       
        $doctrine=$this->getDoctrine();
        $qb = $doctrine->getRepository('AppBundle:Beitraege\Dues')->createQueryBuilder('d');
        
        if($type!='alle'){
            switch ($type){
                case 'standart': $t = 0;
                    break;
                case 'angepasst': $t = 1;
                    break;
            }
            $qb->where('d.type=:type')
               ->setParameter('type', $t);
        }
        if($state!='alle'){
            switch ($state){
                case 'aktuell': $s = 0;
                    break;
                case 'veraltet': $s = 1;
                    break;
            }
            $qb->andWhere('d.state=:state')
               ->setParameter('state', $s);
        }
        
        $choices=array('Beitragsnr.' => 'dueid',
        'Name' => 'name',
        'Preis' => 'price');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('dues_home')));
    $searchform->handleRequest($request);
    
    if($searchform->isSubmitted() && $searchform->isValid()){
       $type='alle';
       $state='alle';
       $searchval=$request->query->get('search')['searchfield'];
       $searchcol=$request->query->get('search')['column'];
       $qb  ->andWhere($qb->expr()->like('d.'.$searchcol, ':searchval'))
            ->setParameter('searchval', '%'.$searchval.'%');
               
    }
        
        $dueslist=$qb->getQuery()->getResult();
        
        return $this->render(
        'Dues/dues.html.twig',
        array(
            'tabledata' => $dueslist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'currtype' => $type,
            'currstate' => $state,

            'path' => 'dues_home'
           
         
            ));
    }
    
        //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * @Route("/beitraege/anlegen", name="adddues")
     * 
     */
    public function addDuesAction(Request $request)
    {
        $doctrine=$this->getDoctrine();   
        $manager= $doctrine->getManager();
        $tm= new ToolsManager($this);
        
        $due= new Dues();
        $price = new DuesPrice();
        
        $due->addDuescharge($price);
        
        $adddueform = $this->createForm(DuesType::class, $due);
        
        $adddueform->handleRequest($request);

        if($adddueform->isSubmitted() && $adddueform->isValid()){
            $manager->persist($due);
            
            
            $manager->persist($price);
            
            $manager->flush();
            
   
           $this->addFlash('notice', 'Dieser Beitrag wurde erfolgreich angelegt!'); 
          return $this->redirectToRoute('dues_home');
        }
        
        return $this->renderDuesForm($adddueform,'anlegen');
    }
    
    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 
    
    /**
     * @Route("/beitraege/bearbeiten/{ID}", name="editdues")
     * 
     */
    public function editDuesAction(Request $request, $ID)
    {

    
    $doctrine=$this->getDoctrine(); 
    $manager= $doctrine->getManager();
    $tm = new ToolsManager($manager);

    $due=$doctrine->getRepository('AppBundle:Beitraege\Dues')->findOneBy(array('dueid'=>$ID));
      
    if (!$due) 
    {
        throw $this->createNotFoundException('Es konnte kein Beitrag mit der Beitragsnr.: '.$ID.' gefunden werden');
    }
    
    $originalprices = $tm->copyArrayCollection($due->getDuescharge());


    $editdueform = $this->createForm(DuesType::class, $due, array('isEdit'=>true));
    

    $editdueform->handleRequest($request);
     
    if($editdueform->get('delete')->isClicked())
    {
        $manager->remove($due);
        $manager->flush();

        $this->addFlash('notice', 'Dieser Beitrag wurde erfolgreich gelöscht!');
        return $this->redirectToRoute('dues_home');
    }
        
        if($editdueform->isSubmitted() && $editdueform->isValid())
        {
            $manager->persist($due);
            
            $tm->sortOutRemoved($originalprices, $due->getDuescharge());

            $manager->flush();
 
               
            $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!');  
            return $this->redirectToRoute('dues_home');
        }
        
             return $this->renderDuesForm($editdueform,'bearbeiten');
    
    }
    
    public function renderDuesForm($duesForm, $type)
    {
        return $this->render(
        'Dues/duesform.html.twig',
        array(        
            'form' => $duesForm->createView(),
            'title' => 'Beitrag '.$type
            ));
    }

}
