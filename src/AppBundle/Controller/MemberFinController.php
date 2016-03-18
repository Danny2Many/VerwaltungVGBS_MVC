<?php



namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;

class MemberFinController extends Controller{
    
    
    /**
     * @Route("/mitglieder/finanzen/{year}/{halfyear}/{letter}", defaults={"year"=2016,"halfyear"=1, "letter"="A"}, name="member_fin", requirements={ "letter": "[A-Z]", "year": "[1-9][0-9]{3}", "halfyear": "1|2"})
     */
    public function indexAction(Request $request,$letter, $year, $halfyear){
        
    
        $adminyearrepository = $this->getDoctrine()->getRepository('AppBundle:AdministrationYear');
        $memrepository = $this->getDoctrine()->getRepository('AppBundle:Member');
        
        $adminyears=$adminyearrepository->findAll();
        
        
        
        $qb = $memrepository->createQueryBuilder('m');
        
        $qb->Join('m.yearinfo', 'i')
           
           ->where('i.year ='.$year);
           
    
        $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_fin')));

        $searchform->handleRequest($request);
    
    
    
    if($searchform->isSubmitted()){
    $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['column'];
    
    
    
    
    $query=$qb->where($qb->expr()->like('m.'.$searchcol, ':member'))
                   ->setParameter('member','%'.$searchval.'%')
                   ->getQuery();
    
    $memberfinlist=$query->getResult();
    
     
     
    }else{
        
        
        $query=$qb->where($qb->expr()->like('m.lastname', ':letter'))
                   ->setParameter('letter',$letter.'%');
                   
        
        
          switch($letter){
            case 'A': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ä%'); 
            break;
        
            case 'O': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ö%'); 
            break;
        
            case 'U': $qb->orWhere($qb->expr()->like('m.lastname', ':umlautletter'))
                         ->setParameter('umlautletter','Ü%'); 
            break;
        }
        
        $memberfinlist=$query->getQuery()->getResult();
      
        
    }
    
    
    
        return $this->render(
        'Mitglieder/memberfin.html.twig',
        array(
            'tabledata' => $memberfinlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            
            
            'cletter' => $letter,
            'path' => 'member_fin',
            'finyears' => $adminyears,
            'year' => $year,
            'halfyear' => $halfyear,

            
         
            ));
    }
}
