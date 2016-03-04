<?php

namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerFocus")
 */
class TrainerFocus{
    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="focus")
     * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
     */
    protected $trainer;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")     
     */    
    protected $trainerid;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */   
    protected $focus;
}
