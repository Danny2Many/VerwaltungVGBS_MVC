<?php



namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;

class MemberFinController extends Controller{
    
    
    /**
     * @Route("/finanzen/mitglieder/{year}/{halfyear}/{letter}", defaults={"year"=2016,"halfyear"=1, "letter"="A"}, name="member_fin", requirements={ "letter": "[A-Z]", "year": "[1-9][0-9]{3}", "halfyear": "1|2"})
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
    
    
    
    
    /**
     * @Route("/finanzen/mitglieder/bearbeiten/{year}/{letter}/{ID}", defaults={"letter": "[A-Z]"}, requirements={"ID": "\d+", "letter": "[A-Z]", "year": "[1-9][0-9]{3}"}, name="editmem")
     * 
     */
    public function editmemberAction(Request $request, $ID, $letter)
    {
        $manager= $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
    ->getRepository('AppBundle:Member');
        
        $member=$repository->findOneBy(array('memid' => $ID));
        
        
     if (!$member) {
        throw $this->createNotFoundException('Es konnte kein Mitglied mit der Mitgliedsnr.: '.$ID.' gefunden werden');
    }
       
      
        $editmemform = $this->createForm(EditMemberType::class, $member);
        
        
         $originalrehabs = new ArrayCollection();
         $originalphonenr = new ArrayCollection();

    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getRehabilitationcertificate() as $rehab) {
        $originalrehabs->add($rehab);
    }
     
    // Create an ArrayCollection of the current Rehab objects in the database
    foreach ($member->getPhonenumber() as $phonenr) {
        $originalphonenr->add($phonenr);
    }
    
        $editmemform->handleRequest($request);
        
        
        if($editmemform->get('delete')->isClicked()){
            $manager=$this->getDoctrine()->getManager();
           
            $manager->remove($member);
            $manager->flush();
            $this->addFlash('notice', 'Diese Person wurde erfolgreich gelöscht!'); 
            return $this->redirectToRoute('member_home', array('letter' => $letter));
        }

        
       
    
        //if the form is valid -> persist it to the database
        if($editmemform->isSubmitted() && $editmemform->isValid()){
  
          foreach ($originalrehabs as $rehab) {
            if (false === $member->getRehabilitationcertificate()->contains($rehab)) {
                

                $manager->remove($rehab);

            }
        }
            
            foreach ($originalphonenr as $phonenr) {
            if (false === $member->getPhonenumber()->contains($phonenr)) {
                

                $manager->remove($phonenr);

            }
        }
           
            $manager->persist($member);
            
            $manager->flush();
            
          $this->addFlash('notice', 'Die Daten wurden erfolgreich gespeichert!'); 
          return $this->redirectToRoute('member_home', array('letter' => $letter));  
        }
        
        
      return $this->render(
        'Mitglieder/memberform.html.twig',
        array(
            
            'form' => $editmemform->createView(),
            'cletter' => $letter,
            'title' => 'Mitglied bearbeiten'
            ));
    }
}
