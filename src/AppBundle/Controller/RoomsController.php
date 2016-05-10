<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoomsController extends Controller{
    /**
    * @Route("/räume/{adminyear}/{letter}", defaults={"letter"="alle", "adminyear"=2016}, name="rooms_home" , requirements={"letter": "[A-Z]|alle", "adminyear": "[1-9][0-9]{3}"})
    */ 
     public function indexAction (Request $request, $letter, $adminyear){
    }
}
