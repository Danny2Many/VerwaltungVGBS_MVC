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
        
    
        $finyearrepository = $this->getDoctrine()->getRepository('AppBundle:MemFinYear');
        $memrepository = $this->getDoctrine()->getRepository('AppBundle:Member');
        
        $finyears=$finyearrepository->findAll();
        
        
        
        $qb = $memrepository->createQueryBuilder('m');
        
        $qb->Join('m.yearinfo', 'i')
           
           ->where('i.year = 2016');
           
        $monthsfirsthalfyear=['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni'];
        $monthssecondhalfyear=['Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
        
         $searchval=null;
         $searchcol=null;
        
        switch($halfyear){
            case 1:
                $monthshalfyear=$monthsfirsthalfyear;
                break;
            case 2:
                $monthshalfyear=$monthssecondhalfyear;
        }

        foreach ($monthshalfyear as $month){
            $qb->orWhere('md.month='.$month);
            
        }
        
        $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_fin')));

        $searchform->handleRequest($request);
    
    
    
    if(isset($request->query->get('search')['search'])){
    $letter=null;   
    $searchval=$request->query->get('search')['searchfield'];
    $searchcol=$request->query->get('search')['Spalte'];
    
    
    
    
    $query=$qb->where($qb->expr()->like('m.'.$searchcol, ':member'))
                   ->setParameter('member','%'.$searchval.'%')
                   ->getQuery();
    
    $memberfinlist=$query->getResult();
    
     $disabled='';
     
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
      
        $disabled='disabled';
    }
    
    
    
        return $this->render(
        'Mitglieder/memberfin.html.twig',
        array(
            'tabledata' => $memberfinlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            'disabled' => $disabled,
            
            'cletter' => $letter,
            'path' => 'member_fin',
            'finyears' => $finyears,
            'year' => $year,
            'halfyear' => $halfyear,

            
         
            ));
    }
}
