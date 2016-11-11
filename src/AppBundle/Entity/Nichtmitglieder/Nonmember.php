<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember")
 * 
 */
class NonMember extends HealthData {


    /**
     * @ORM\OneToMany(targetEntity="NonMemRehabilitationCertificate", mappedBy="nonmember", cascade={"persist"})
     */
    protected $rehabilitationcertificate;

    
    /**
     * @ORM\OneToMany(targetEntity="NonMemPhoneNumber", mappedBy="nonmember", cascade={"persist"})
     */
    protected $phonenumber;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="NonMember_Sportsgroup", mappedBy="nonmember", cascade={"persist"})
     */
    protected $sportsgroup; 


/**
* @ORM\Id
* @ORM\Column(type="integer")
 *@ORM\GeneratedValue(strategy="AUTO")  
*/
protected $nmemid;    


    
/**
* @ORM\Column(type="integer")
* @Assert\NotBlank()
* @Assert\Choice(choices = {"0", "1"}, message = "Bitte wählen Sie einen gültigen Status.")
*/
protected $state;


/**
* @ORM\Column(type="date")
 *@Assert\NotBlank
 *@Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
 * 
*/
protected $trainingstartdate;

/**
* @ORM\Column(type="date")
*/
protected $trainingconfirmation;

/**
* @ORM\Column(type="string")
*/
protected $additionalinfo;




/**
* @ORM\Column(type="integer")
* 
*/protected $newsletter; 


    

    public function __construct()
    {
        $this->phonenumber = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        $this->sportsgroup = new ArrayCollection();

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
     * Set state
     *
     * @param integer $state
     *
     * @return NonMember
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set trainingstartdate
     *
     * @param \DateTime $trainingstartdate
     *
     * @return NonMember
     */
    public function setTrainingstartdate($trainingstartdate)
    {
        $this->trainingstartdate = $trainingstartdate;

        return $this;
    }

    /**
     * Get trainingstartdate
     *
     * @return \DateTime
     */
    public function getTrainingstartdate()
    {
        return $this->trainingstartdate;
    }

    /**
     * Set trainingconfirmation
     *
     * @param \DateTime $trainingconfirmation
     *
     * @return NonMember
     */
    public function setTrainingconfirmation($trainingconfirmation)
    {
        $this->trainingconfirmation = $trainingconfirmation;

        return $this;
    }

    /**
     * Get trainingconfirmation
     *
     * @return \DateTime
     */
    public function getTrainingconfirmation()
    {
        return $this->trainingconfirmation;
    }

    /**
     * Set additionalinfo
     *
     * @param string $additionalinfo
     *
     * @return NonMember
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
     * Set newsletter
     *
     * @param integer $newsletter
     *
     * @return NonMember
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = implode($newsletter);

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return integer
     */
    public function getNewsletter()
    {
        return array($this->newsletter);
    }

    /**
     * Add rehabilitationcertificate
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate
     *
     * @return NonMember
     */
    public function addRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $rehabilitationcertificate->setNonMember($this);
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

    /**
     * Get rehabilitationcertificate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRehabilitationcertificate()
    {
        return $this->rehabilitationcertificate;
    }

    /**
     * Add phonenumber
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber
     *
     * @return NonMember
     */
    public function addPhonenumber(\AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber)
    {
        $phonenumber->setNonMember($this);
        $this->phonenumber[] = $phonenumber;

        return $this;
    }

    /**
     * Remove phonenumber
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber
     */
    public function removePhonenumber(\AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber)
    {
        $this->phonenumber->removeElement($phonenumber);
    }

    /**
     * Get phonenumber
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Add sportsgroup
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup $sportsgroup
     *
     * @return NonMember
     */
    public function addSportsgroup(\AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup $sportsgroup)
    {
        $sportsgroup->setNonMember($this);
        $this->sportsgroup[] = $sportsgroup;

        return $this;
    }

    /**
     * Remove sportsgroup
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup $sportsgroup
     */
    public function removeSportsgroup(\AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup $sportsgroup)
    {
        $this->sportsgroup->removeElement($sportsgroup);
    }

    /**
     * Get sportsgroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSportsgroup()
    {
        return $this->sportsgroup;
    }
}
