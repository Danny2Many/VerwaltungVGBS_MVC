<?php



namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;

class MemberFinController extends Controller{
    
    
    /**
     * @Route("/mitglieder/finanzen/{year}/{halfyear}/{letter}/{info}", defaults={"year"=2016,"halfyear"=1,"info"=null, "letter"="A"}, name="member_fin", requirements={"info": "null|gespeichert|entfernt", "letter": "[A-Z]"})
     */
    public function indexAction(Request $request,$letter, $info, $year, $halfyear){
        
        switch($info){
        case 'gespeichert':
        $info='Die Daten wurden erfolgreich gespeichert.';
        break;
        
        case 'entfernt':
        $info='Diese Person wurde erfolgreich aus ihrer Datenbank entfernt.';
        break;
    }
        $finyearrepository = $this->getDoctrine()->getRepository('AppBundle:MemFinYear');
        $memrepository = $this->getDoctrine()->getRepository('AppBundle:Member');
        
        $finyears=$finyearrepository->findAll();
        
        
        
        $qb = $memrepository->createQueryBuilder('m');
        
        $qb->Join('m.yearinfo', 'i')
           ->where('i.year = 2016');
           
        
         
        $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_fin')));

        $searchform->handleRequest($request);
    
    
    
    if($searchform->isSubmitted() && $searchform->isValid()){
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
        
        $query=$query->getQuery()->getResult();
        
        $memberfinlist=$query;
        $disabled='disabled';
    }
    
    
    
        return $this->render(
        'Mitglieder/memberfin.html.twig',
        array(
            'tabledata' => $memberfinlist,
            'colorclass' => "redtheader",
            'searchform' => $searchform->createView(),
            'disabled' => $disabled,
            'info' => $info,
            'cletter' => $letter,
            'path' => 'member_fin',
            'finyears' => $finyears,
            'year' => $year
         
            ));
    }
}
