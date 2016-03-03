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
        return $this->render('Trainer/trainer.html.twig',
                array('info'=>$info,
                    'tabledata'=>null,
                    'cletter'=>null,
                    'path'=>'trainer_home'));
    }
}
