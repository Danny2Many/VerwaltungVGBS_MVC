<?php

namespace AppBundle\Entity\Trainer;

//use AppBundle\Entity\PersonalData;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerPhoneNumber")
 */

class TrainerPhoneNumber {
    
    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="phonenumber")
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
    protected $phonenumber;
    
   

    /**
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return TrainerPhoneNumber
     */
    public function setTrainerid($trainerid)
    {
        $this->trainerid = $trainerid;

        return $this;
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

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return TrainerPhoneNumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set trainer
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainer
     *
     * @return TrainerPhoneNumber
     */
    public function setTrainer(\AppBundle\Entity\Trainer\Trainer $trainer = null)
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * Get trainer
     *
     * @return \AppBundle\Entity\Trainer\Trainer
     */
    public function getTrainer()
    {
        return $this->trainer;
    }
}
