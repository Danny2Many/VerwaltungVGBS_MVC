<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TrainerController extends Controller
{
    /**
     * @Route("/trainer/{info}", defaults={"info"=null},name="trainer_home")
     */
    public function indexAction ($info)
    {
        
        $repository = $this->getDoctrine()
        ->getRepository('AppBundle:Trainer\Trainer');
        
        $qb=$repository->createQueryBuilder('t');
        
        $query=$qb->where($qb->expr()->like('t.lastname', ':letter'))
                   ->setParameter('letter','P%');
        
        $trainerlist=$query->getQuery()->getResult();
        
        return $this->render('Trainer/trainer.html.twig',
                array('info'=>$info,
                    'tabledata'=>$trainerlist,
                    'colorclass'=>"bluetheader",
                    'cletter'=>null,
                    'path'=>'trainer_home'));
    }
}
