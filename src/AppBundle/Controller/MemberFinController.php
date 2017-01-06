<?php



namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Member\FinanceMemberType;


class MemberFinController extends Controller{
    
    
    /**
     * @Route("/finanzen/mitglieder/{year}/{halfyear}/{letter}", defaults={"year"=2016,"halfyear"=1, "letter"="A"}, name="member_fin", requirements={ "letter": "[A-Z]", "year": "[1-9][0-9]{3}", "halfyear": "1|2"})
     */
    public function indexAction(Request $request,$letter, $year, $halfyear){
        
    
      
        
        $memrepository = $this->getDoctrine()->getRepository('AppBundle:Mitglieder\Member');


        
        
        
        $qb = $memrepository->createQueryBuilder('m');

        
           
    
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
    
    
    
    
    $query=$qb['Member']->where($qb->expr()->like('m.'.$searchcol, ':member'))
                   ->setParameter('member','%'.$searchval.'%')
                   ->getQuery();
    
    
    
     
     
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
        
        
      
        
    }
    

    

    $memberfinlist=$query->getQuery()->getResult();
        return $this->render(
        'Mitglieder/memberfin.html.twig',
        array(
            'tabledata' => $memberfinlist,
            'colorclass' => "bluetheader",
            'searchform' => $searchform->createView(),
            
            
            'cletter' => $letter,
            'path' => 'member_fin',
         
            'year' => $year,
            'halfyear' => $halfyear,

            
         
            ));
    }
    
    
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /**
     * @Route("/finanzen/mitglieder/bearbeiten/{year}/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"ID": "\d+", "letter": "[A-Z]", "year": "[1-9][0-9]{3}"}, name="editmemfin")
     * 
     */
    public function editmemberAction(Request $request, $ID, $letter, $year)
    {
        $manager=$this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Member');

//        $qb->join('m.monthlydues', 'md')
//           ->join('m.yearinfo', 'yi')
//           ->where('md.year='.$year)
//           ->andWhere('yi.year='.$year)
//           ->andWhere('m.memid='.$ID);
//        
//        
//        $query=
        
        $member=$repository->findOneBy(array('memid' => $ID));
        
        
     if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
       
      
        $editmemfinform = $this->createForm(FinanceMemberType::class, $member);
 
        $editmemfinform->handleRequest($request);
        
        
       
    
        //if the form is valid -> persist it to the database
        if($editmemfinform->isSubmitted() && $editmemfinform->isValid()){
            $manager->persist($member);
            $manager->flush();
  
           
        }
        
        
      return $this->render(
        'Mitglieder/memberfinform.html.twig',
        array(
            
            'form' => $editmemfinform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied bearbeiten',
            'year' => $year
            ));
    }
}
