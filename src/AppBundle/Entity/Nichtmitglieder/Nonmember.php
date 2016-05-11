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
//    

protected $sportsgroup; 


/**
* @ORM\Id
* @ORM\Column(type="integer")  
*/
protected $nmemid;    

public function __toString(){
    return (string) $this->nmemid.'/nmem/Nonmember';
   
}
    
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
* @ORM\Id
* @ORM\Column(type="string")
*/
protected $validfrom;

/**
* @ORM\Column(type="string")
*/
protected $validto;

/**
* @ORM\Column(type="integer")
* 
*/protected $newsletter; 


    

    /**
     * @ORM\PostLoad
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
     * @return integer
     */
    public function getNMemID()
    {
        return $this->nmemid;
    }
    
     /**
     * Set nmemid
     *
     * @param integer $nmemid
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
        $this->rehabilitationcertificate->add($rehabilitationcertificate);

        return $this;
        
    }

 
    public function removeRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $this->rehabilitationcertificate->removeElement($rehabilitationcertificate);
    }

    /**
     * Set integer
     *
     * @param integer $state
     *
     * @return Nonmember
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get integer
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add sportsgroup
     *
     * @param \AppBundle\Entity\Nichtmitglieder\onMember_Sportsgroup $sportsgroup
     *
     * @return Nonmember
     */
    public function addSportsgroup(\AppBundle\Entity\Nichtmitglieder\NonMember_Sportsgroup $sportsgroup)
    {

        $sportsgroup->setNmemid($this->nmemid);
        $this->sportsgroup->add($sportsgroup);

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
        $this->phonenumber->add($phonenumber);

        return $this;
    }

    /**
     * Remove phonenumber
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber
    */
    public function removePhonenumber(\AppBundle\Entity\Nichtmitglieder\NonMemPhoneNumber $phonenumber)
    {
        $this->getPhonenumber()->removeElement($phonenumber);
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
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
     * @return boolean
     */
    public function getNewsletter()
    {
        return array($this->newsletter);
    }
    
    

    public function setValidfrom($validfrom)
    {
        
        $this->validfrom  = $validfrom;

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
     * Set validto
     *
     * @param string $validto
     *
     * @return Nonmember
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
}
