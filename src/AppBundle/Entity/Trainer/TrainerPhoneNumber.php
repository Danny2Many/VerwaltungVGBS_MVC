<?php

namespace AppBundle\Entity\Trainer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerPhoneNumber")
 */
class TrainerPhoneNumber {
    
    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="phonenumber", cascade={"persist"})
     * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
     */
    private $trainer;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $tpnid;
    
    /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $trainerid;   
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d\/\d/",
     *     message="Ihre Telefonnummer entspricht entweder nicht dem gegebenen Format oder enthält einen Buchstaben."
     * )
     */
    protected $phonenumber;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $deleted;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="date")
     */
    protected $recorded;
    

    /**
     * Get tpnid
     *
     * @return integer
     */
    public function getTpnid()
    {
        return $this->tpnid;
    }

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

    /**
     * Set tpnid
     *
     * @param integer $tpnid
     *
     * @return TrainerPhoneNumber
     */
    public function setTpnid($tpnid)
    {
        $this->tpnid = $tpnid;

        return $this;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return TrainerPhoneNumber
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set recorded
     *
     * @param \DateTime $recorded
     *
     * @return TrainerPhoneNumber
     */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * Get recorded
     *
     * @return \DateTime
     */
    public function getRecorded()
    {
        return $this->recorded;
    }
}
