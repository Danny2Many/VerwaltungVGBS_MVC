<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember")
 */
class Nonmember extends HealthData {

/**
* @ORM\Id
* @ORM\Column(type="integer") 
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $nmemid;    
    
/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $trainingstartdate;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $trainingconfirmation;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/  
protected $settlementdate1;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $settlementdate2;
 

/**
* @ORM\Column(type="string")
*/
protected $additionalinfo;

/**
* @ORM\OneToMany(targetEntity="NonMemRehabilitationCertificate", mappedBy="nonmember", cascade={"all"})
*/
protected $rehabilitationcertificate;

 /**
 ** @ORM\OneToMany(targetEntity="NonMemPhoneNumber", mappedBy="nonmember", cascade={"persist"})
 */
protected $phonenumber;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get nmemID
     *
     * @return integer
     */
    public function getNMemID()
    {
        return $this->nmemid;
    }

    /**
     * Set trainingDate
     *
     * @param \DateTime $trainingstartdate
     *
     * @return NonMember
     */
    public function SetTrainingStartDate($trainingstartdate)
    {
        $this->trainingstartdate = $trainingstartdate;

        return $this;
    }

    /**
     * Get trainingDate
     *
     * @return \DateTime
     */
    public function getTrainingStartDate()
    {
        return $this->trainingstartdate;
    }

    /**
     * Set trainingConfirmation
     *
     * @param \DateTime $trainingconfirmation
     *
     * @return NonMember
     */
    public function setTrainingConfirmation($trainingconfirmation)
    {
        $this->trainingconfirmation = $trainingconfirmation;

        return $this;
    }

    /**
     * Get trainingConfirmation
     *
     * @return \DateTime
     */
    public function getTrainingConfirmation()
    {
        return $this->trainingconfirmation;
    }

    /**
     * Set settlement1
     *
     * @param \DateTime $settlementdate1
     *
     * @return NonMember
     */
    public function setSettlementdate1($settlementdate1)
    {
        $this->settlementdate1 = $settlementdate1;

        return $this;
    }

    /**
     * Get settlement1
     *
     * @return \DateTime
     */
    public function getSettlementdate1()
    {
        return $this->settlementdate1;
    }

    /**
     * Set settlement2
     *
     * @param \DateTime $settlementdate2
     *
     * @return NonMember
     */
    public function setSettlementdate2($settlementdate2)
    {
        $this->settlementdate2 = $settlementdate2;

        return $this;
    }

    /**
     * Get settlement2
     *
     * @return \DateTime
     */
    public function getSettlementdate2()
    {
        return $this->settlementdate2;
    }

    /**
     * Set stresstest
     *
     * @param string $stresstest
     *
     * @return NonMember
     */
    public function setStresstest($stresstest)
    {
        $this->stresstest = $stresstest;

        return $this;
    }

    /**
     * Get stresstest
     *
     * @return string
     */
    public function getStresstest()
    {
        return $this->stresstest;
    }

    /**
     * Set additionalinfo
     *
     * @param string $additionalinfo
     *
     * @return Nonmember
     */
    public function setAdditionalinfo($additionalinfo)
    {
        $this->additionalinfo = $additionalinfo;

        return $this;
    }

    /**
     * Get additionalinfo
     *
     * @return string
     */
    public function getAdditionalinfo()
    {
        return $this->additionalinfo;
    }

    /**
     * Set rehabilitationcertificate
     *
     * @param \DateTime $rehabilitationcertificate
     *
     * @return Nonmember
     */
    public function setRehabilitationcertificate($rehabilitationcertificate)
    {
        $this->rehabilitationcertificate = $rehabilitationcertificate;

        return $this;
    }

    /**
     * Get rehabilitationcertificate
     *
     * @return \DateTime
     */
    public function getRehabilitationcertificate()
    {
        return $this->rehabilitationcertificate;
    }

    /**
     * Add rehabilitationcertificate
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate
     *
     * @return Nonmember
     */
    public function addRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
    }

    /**
     * Remove rehabilitationcertificate
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate
     */
    public function removeRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $this->rehabilitationcertificate->removeElement($rehabilitationcertificate);
    }
}
