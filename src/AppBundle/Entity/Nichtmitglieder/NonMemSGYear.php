<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemSGYear")
 */
class NonMemSGYear {

        
    /**
    * @ORM\Id
    * @ORM\Column(type="integer") 
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $sgid;

    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
     */
    protected $roomid;
    
     /**
     * @ORM\Column(type="integer")
     */
    protected $trainerid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $capacitytotal;

}