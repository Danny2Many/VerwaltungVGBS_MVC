<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NonMemberController extends Controller
{
    /**
     * @Route("/nichtmitglieder", name="nonmember")
     */
    public function indexAction(Request $request)
    {
        return $this->render('Nicht_Mitglieder/nonmember.html.twig', array('cletter'=>NULL, 'info'=>NULL, 'tabledata' => NULL));
    }
}
