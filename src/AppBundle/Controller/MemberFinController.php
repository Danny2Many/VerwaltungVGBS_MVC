<?php



namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\Type\SearchType;

class MemberFinController extends Controller{
    
    
    /**
     * @Route("/mitglieder/finanzen", name="member_fin")
     */
    public function indexAction(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Member');
        
        $qb = $repository->createQueryBuilder('m');
        
        $qb->Join('m.yearinfo', 'i')
           ->where('i.year = 2016');
           
        $query=$qb->getQuery();
        $memberfinlist =$query->getResult();
         
        $choices=array('Mitgliedsnr.' => 'memid',
        'Name' => 'lastname',
        'Vorname' => 'firstname',
        'Strasse' => 'streetaddress',
        'E-Mail' => 'email');
     
 
    $searchform = $this->createForm(SearchType::class, null, array('choices' => $choices, 'action' => $this->generateUrl('member_fin')));

        
        return $this->render(
        'Mitglieder/memberfin.html.twig',
        array(
            'tabledata' => $memberfinlist,
            'colorclass' => "redtheader",
            'searchform' => $searchform->createView(),
            'disabled' => '$disabled',
            'info' => '$info',
            'cletter' => null
         
            ));
    }
}
