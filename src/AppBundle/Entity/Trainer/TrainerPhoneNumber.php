<?php

namespace AppBundle\Entity\Trainer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerPhoneNumber")
 * @ORM\HasLifecycleCallbacks()
 */
class TrainerPhoneNumber {
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $tpnid;
    
  
    
     
    /**
     * @ORM\Column(type="string") 
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
     * @ORM\Column(type="string")
     */
    protected $validto;
    
    /**
     * @ORM\Id 
     * @ORM\Column(type="string")
     */
    protected $validfrom;
    

  
    /**
     * Set trainerid
     *
     * @param string $trainerid
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
     * @return string
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
     * Set validto
     *
     * @param string $validto
     *
     * @return TrainerPhoneNumber
     */
    public function setValidto($validto)
    {
        $this->validto = $validto;

        return $this;
    }

    /**
     * Get validto
     *
     * @return string
     */
    public function getValidto()
    {
        return $this->validto;
    }

    /**
     * @ORM\PrePersist
     */
    public function setValidfrom()
    {
        $now= new \DateTime();
        
        $this->validfrom = $now->format('Y');

        return $this;
    }

    /**
     * Get validfrom
     *
     * @return string
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }
    
    /**
     * Set tpnid
     *
     * @param string $tpnid
     *
     * @return TrainerPhoneNumber
     */
    public function setTpnid($tpnid)
    {
        $this->tpnid = $tpnid;

        return $this;
    }

    /**
     * Get tpnid
     *
     * @return string
     */
    public function getTpnid()
    {
        return $this->tpnid;
    }
}
