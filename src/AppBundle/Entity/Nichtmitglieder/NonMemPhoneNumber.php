<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemPhoneNumber")
 */
class NonMemPhoneNumber {
    
  /**
     * @ORM\ManyToOne(targetEntity="Nonmember", inversedBy="phonenumber", cascade={"persist"})
     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
     */
    private $nonmember;
     
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $phid;
   
    /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $nmemid;   
    
   /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $phonenumber;
    
    /**
    * @ORM\Column(type="string")
    */
    protected $recorded;

    /**
    * @ORM\Column(type="date")
    */
    protected $deleted;



    /**
     * Get phid
     *
     * @return integer
     */
    public function getPhid()
    {
        return $this->phid;
    }

    /**
     * Set nmemid
     *
     * @param integer $nmemid
     *
     * @return NonMemPhoneNumber
     */
    public function setNmemid($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
    }

    /**
     * Get nmemid
     *
     * @return integer
     */
    public function getNmemid()
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
     * Set nonmember
     *
     * @param \AppBundle\Entity\Nichtmitglieder\Nonmember $nonmember
     *
     * @return NonMemPhoneNumber
     */
    public function setNonmember(\AppBundle\Entity\Nichtmitglieder\Nonmember $nonmember = null)
    {
        $this->nonmember = $nonmember;

        return $this;
    }

    /**
     * Get nonmember
     *
     * @return \AppBundle\Entity\Nichtmitglieder\Nonmember
     */
    public function getNonmember()
    {
        return $this->nonmember;
    }

    /**
     * Set recorded
     *
     * @param \String $recorded
     *
     * @return NonMemPhoneNumber
     */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * Get recorded
     *
     * @return \String
     */
    public function getRecorded()
    {
        return $this->recorded;
    }

 



    /**
     * Set deleted
     *
     * @param \DateTime $deleted
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
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set phid
     *
     * @param integer $phid
     *
     * @return NonMemPhoneNumber
     */
    public function setPhid($phid)
    {
        $this->phid = $phid;

        return $this;
    }
}
