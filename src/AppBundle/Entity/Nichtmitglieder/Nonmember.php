<?php

namespace AppBundle\Entity\Nichtmitglieder;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember")
 * @ORM\HasLifecycleCallbacks()
 */
class Nonmember extends HealthData {

 
protected $rehabilitationcertificate;
protected $phonenumber; 
//
///**
//* @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
//* @ORM\JoinTable(name="NonMember_Section",
//* joinColumns={@ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")},
//* inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
//*/
//protected $section;    
//    
    
/**
* @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Nichtmitglieder\NonMemSportsgroup")
* @ORM\JoinTable(name="NonMember_Sportsgroup",
* joinColumns={@ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")},
* inverseJoinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")})
*/ 
protected $sportsgroup; 

/**
* @ORM\Id
* @ORM\Column(type="string")  
*/
protected $nmemid;    

public function __toString(){
    return $this->nmemid;
}
    
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
* @ORM\Id
* @ORM\Column(type="string")
*/
protected $recorded;

/**
* @ORM\Column(type="date")
*/
protected $deleted;

/**
* @ORM\Column(type="binary")
* 
*/protected $newsletter; 
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        //$this->section = new ArrayCollection();
    }

    /**
     * Get nmemid
     *
     * @return string
     */
    public function getNMemID()
    {
        return $this->nmemid;
    }
    
     /**
     * Set nmemid
     *
     * @param string $nmemid
     *
     * @return Nonmember
     */
    public function setNMemID($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
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


    public function setRehabilitationcertificate($rehabilitationcertificate)
    {   $rehabilitationcertificate->setNMemID($this->nmemid);
        $this->rehabilitationcertificate = $rehabilitationcertificate;

        return $this;
    }

   
    public function getRehabilitationcertificate()
    {
        return $this->rehabilitationcertificate;
    }


    public function addRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $rehabilitationcertificate->setNMemID($this->nmemid);
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
        
    }

 
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

//    /**
//     * Add section
//     *
//     * @param \AppBundle\Entity\Section $section
//     *
//     * @return Nonmember
//     */
//    public function addSection(\AppBundle\Entity\Section $section)
//    {  
//        if(!$this->section->contains($section)){
//        $this->section[] = $section;
//        return $this;
//        }
//    }
//    
//    /**
//     * Remove section
//     *
//     * @param \AppBundle\Entity\Section $section
//     */
//    public function removeSection(\AppBundle\Entity\Section $section)
//    {
//        $this->section->removeElement($section);
//    }
//
//    /**
//     * Get section
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getSection()
//    {
//        return $this->section;
//    }
//
//     /**
// * Set categories
// * 
// *
// * @return Post
// */
//public function setSection($section)
//{
//
//    if(!is_array($section))
//    {
//        $section = array($section);
//    }
//    $this->section = $section;
//
//    return $this;
//} 
   
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
     


 public function addPhonenumber(\AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber)
    {               
        $phonenumber->setNMemID($this);
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
     * @param \DateTime $deleted
     *
     * @return Nonmember
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
    * @ORM\PrePersist
    */
    public function setRecorded($recorded)
    {   
        $now= new \DateTime();
        $this->recorded = $now->format('Y-m-d');

        return $this;
    }

    /**
     * Set newsletter
     *
     * @param binary $newsletter
     *
     * @return Nonmember
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = implode($newsletter);

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return binary
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
    
    
}
