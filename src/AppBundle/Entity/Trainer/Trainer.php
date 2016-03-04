<?php

namespace AppBundle\Entity\Trainer;

use AppBundle\Entity\PersonalData;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer")
 */

class Trainer extends PersonalData{
    
   

    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $trainerid;          
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerPhoneNumber", mappedBy="trainer", cascade={"persist"})
     */
    protected $phonenumber;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerLicence", mappedBy="trainer", cascade={"persist"})
     */
    protected $licence;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerFocus", mappedBy="trainer", cascade={"persist"})
     */
    protected $focus;
    
    
    
    
   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new ArrayCollection();
    }

    /**
     * Get trainerid
     *
     * @return integer
     */
    public function getTrainerid()
    {
        return $this->trainerid;
    }
}
