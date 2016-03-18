<?php

namespace AppBundle\Entity\Nichtmitglieder;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember")
 */
class Nonmember extends HealthData {

/**
* @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
* @ORM\JoinTable(name="NonMember_Section",
* joinColumns={@ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")},
* inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
*/
protected $section;    
    
    
/**
* @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup")
* @ORM\JoinTable(name="NonMember_Sportsgroup",
* joinColumns={@ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")},
* inverseJoinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")})
*/ 
protected $sportsgroup; 

/**
* @ORM\Id
* @ORM\Column(type="integer") 
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $nmemid;    
    
/**
* @ORM\Column(type="string")
* @Assert\NotBlank()
* @Assert\Choice(choices = {"aktiv", "inaktiv"}, message = "Bitte wählen Sie einen gültigen Status.")
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
* @ORM\OneToMany(targetEntity="NonMemRehabilitationCertificate", mappedBy="nonmember", cascade={"all"})
*/
protected $rehabilitationcertificate;

/**
  * @ORM\OneToMany(targetEntity="NonMemPhoneNumber", mappedBy="nonmember", cascade={"persist"})
  */
protected $phonenumber;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        $this->section = new ArrayCollection();
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
        if($rehabilitationcertificate->getTerminationdate() != null){
        $rehabilitationcertificate->setNonmember($this);
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
        }
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
     * Set state
     *
     * @param string $state
     *
     * @return Nonmember
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add sportsgroup
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup $sportsgroup
     *
     * @return Nonmember
     */
    public function addSportsgroup(\AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup $sportsgroup)
    {
        $this->sportsgroup[] = $sportsgroup;

        return $this;
    }

    /**
     * Remove sportsgroup
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup $sportsgroup
     */
    public function removeSportsgroup(\AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup $sportsgroup)
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

    /**
     * Add section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Nonmember
     */
    public function addSection(\AppBundle\Entity\Section $section)
    {  
        if(!$this->section->contains($section)){
        $this->section[] = $section;
        return $this;
        }
    }
    
    /**
     * Remove section
     *
     * @param \AppBundle\Entity\Section $section
     */
    public function removeSection(\AppBundle\Entity\Section $section)
    {
        $this->section->removeElement($section);
    }

    /**
     * Get section
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSection()
    {
        return $this->section;
    }

     /**
 * Set categories
 * 
 *
 * @return Post
 */
public function setSection($section)
{

    if(!is_array($section))
    {
        $section = array($section);
    }
    $this->section = $section;

    return $this;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
     

/** 
* Add phonenumber
*
* @param \AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber
*
* @return Nonmember
*/
 public function addPhonenumber(\AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber)
    {               
        $phonenumber->setNonmember($this);
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

    
 

}
