<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemPhoneNumber")
 * @ORM\HasLifecycleCallbacks()
 */
class NonMemPhoneNumber {
    
//  /**
//     * @ORM\ManyToOne(targetEntity="Nonmember", inversedBy="phonenumber", cascade={"persist"})
//     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
//     */
//    private $nonmember;
//     
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     */
    protected $pnid;
   
    /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $nmemid;   
    
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
    protected $validfrom;

  /**
     * @ORM\Column(type="string")
     */
    protected $validto;
    





    /**
     * Set nmemid
     *
     * @param string $nmemid
     *
     * @return NonMemPhoneNumber
     */
    public function setNmemID($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
    }

    /**
     * Get nmemid
     *
     * @return sting
     */
    public function getNmemID()
    {
        return $this->nmemid;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return NonMemPhoneNumber
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
    * @ORM\PrePersist
    */
    public function setRecorded($recorded)
    {
        $now= new \DateTime();
        
        $this->recorded = $now->format('Y-m-d');

        return $this;
    }

    /**
     * Get recorded
     *
     * @return string
     */
    public function getRecorded()
    {
        return $this->recorded;
    }

 



    /**
     * Set deleted
     *
     * @param string $deleted
     *
     * @return NonMemPhoneNumber
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return srtring
     */
    public function getDeleted()
    {
        return $this->deleted;
    }


    /**
     * Set pnid
     *
     * @param string $pnid
     *
     * @return NonMemPhoneNumber
     */
    public function setPnid($pnid)
    {
        $this->pnid = $pnid;

        return $this;
    }

    /**
     * Get pnid
     *
     * @return string
     */
    public function getPnid()
    {
        return $this->pnid;
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
        $this->deleted = $validto;

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
        
        $this->validfrom = $now->format('Y-m-d');

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

 
}
