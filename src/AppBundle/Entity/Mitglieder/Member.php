<?php


namespace AppBundle\Entity\Mitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\HealthData;


/**
 * @ORM\Entity
 * @ORM\Table(name="Member")
 * 
 */
class Member extends HealthData
{
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") 
     * 
     */
    protected $memid;
    
    /**
     * @ORM\OneToMany(targetEntity="MemRehabilitationCertificate", mappedBy="member", cascade={"persist"})
     */
    protected $rehabilitationcertificate;

    
    /**
     * @ORM\OneToMany(targetEntity="MemPhoneNumber", mappedBy="member", cascade={"persist"})
     */
    protected $phonenumber;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="Member_Sportsgroup", mappedBy="member", cascade={"persist"})
     */
    protected $sportsgroup;
    
    

   /**
     * @ORM\OneToMany(targetEntity="Member_Dues", mappedBy="member", cascade={"persist"})
     */
    protected $due;
    
    /**
     * @ORM\OneToMany(targetEntity="MemDuesPayed", mappedBy="member", cascade={"persist"})
     */
    protected $duespayed;
    

    public function __construct() {
        
        $this->sportsgroup = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        $this->phonenumber = new ArrayCollection();
        $this->dues = new ArrayCollection();
        $this->duespayed = new ArrayCollection();
     
    }
        


   
//   public function __toString()
//    {
//        return (string) $this->memid.'/mem/Member';
//    }
    

   
      /**
     * @ORM\Column(type="date")
       * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    public $admissiondate;
    
    /**
     * @ORM\Column(type="date")
       * 
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    public $quitdate;
    
    
  
      /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     * @Assert\Choice(choices = {1, 0}, message = "Bitte wählen Sie einen gültigen Status.")
     */
    public $state;
    
      
    
       /**
     * @ORM\Column(type="date")
        * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    public $admissionconfirmation;
    
    
      
    
       /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * 
     */
    public $decreaseddues;
    
    /**
     * @ORM\Column(type="integer")
        * 
     * 
     */
    public $newsletter; 
    
    
      /**
     * @ORM\Column(type="string")
     */
    public $additionalinfo;

      /**
     * @ORM\Column(type="string")
     */
    protected $tribute;
    
     
    
   
      /**
     * @ORM\Column(type="text")
     */
      protected $inforehabdues;
    
       /**
     * @ORM\Column(type="float")
     */
      protected $admissioncharge;
      
      
       /**
     * @ORM\Column(type="float")
     */
      protected $admissionchargepayed;

    

   

    

    /**
     * Get memid
     *
     * @return integer
     */
    public function getMemid()
    {
        return $this->memid;
    }

    
    
    
    
    /**
     * Set admissiondate
     *
     * @param \DateTime $admissiondate
     *
     * @return Member
     */
    public function setAdmissiondate($admissiondate)
    {
        $this->admissiondate = $admissiondate;

        return $this;
    }

    
    public function getAdmissiondate()
    {
        return $this->admissiondate;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Member
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
     * Set admissionconfirmation
     *
     * @param \DateTime $admissionconfirmation
     *
     * @return Member
     */
    public function setAdmissionconfirmation($admissionconfirmation)
    {
        $this->admissionconfirmation = $admissionconfirmation;

        return $this;
    }

    /**
     * Get admissionconfirmation
     *
     * @return string
     */
    public function getAdmissionconfirmation()
    {
        return $this->admissionconfirmation;
    }

    /**
     * Set decreaseddues
     *
     * @param string $decreaseddues
     *
     * @return Member
     */
    public function setDecreaseddues($decreaseddues)
    {
        $this->decreaseddues = $decreaseddues;

        return $this;
    }

    /**
     * Get decreaseddues
     *
     * @return string
     */
    public function getDecreaseddues()
    {
        return $this->decreaseddues;
    }

   

    /**
     * Set additionalinfo
     *
     * @param string $additionalinfo
     *
     * @return Member
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
     * Set tribute
     *
     * @param string $tribute
     *
     * @return Member
     */
    public function setTribute($tribute)
    {
        $this->tribute = $tribute;

        return $this;
    }

    /**
     * Get tribute
     *
     * @return string
     */
    public function getTribute()
    {
        return $this->tribute;
    }

    

   

    /**
     * Set inforehabdues
     *
     * @param string $inforehabdues
     *
     * @return Member
     */
    public function setInforehabdues($inforehabdues)
    {
        $this->inforehabdues = $inforehabdues;

        return $this;
    }

    /**
     * Get inforehabdues
     *
     * @return string
     */
    public function getInforehabdues()
    {
        return $this->inforehabdues;
    }

    /**
     * Set admissioncharge
     *
     * @param float $admissioncharge
     *
     * @return Member
     */
    public function setAdmissioncharge($admissioncharge)
    {
        $this->admissioncharge = $admissioncharge;

        return $this;
    }

    /**
     * Get admissioncharge
     *
     * @return float
     */
    public function getAdmissioncharge()
    {
        return $this->admissioncharge;
    }

    /**
     * Set admissionchargepayed
     *
     * @param float $admissionchargepayed
     *
     * @return Member
     */
    public function setAdmissionchargepayed($admissionchargepayed)
    {
        $this->admissionchargepayed = $admissionchargepayed;

        return $this;
    }

    /**
     * Get admissionchargepayed
     *
     * @return float
     */
    public function getAdmissionchargepayed()
    {
        return $this->admissionchargepayed;
    }

     
    
    
    
    
    
    

   




   

    /**
     * Set quitdate
     *
     * @param \DateTime $quitdate
     *
     * @return Member
     */
    public function setQuitdate($quitdate)
    {
        $this->quitdate = $quitdate;

        return $this;
    }

    /**
     * Get quitdate
     *
     * @return \DateTime
     */
    public function getQuitdate()
    {
        return $this->quitdate;
    }

    

    /**
     * Set newsletter
     *
     * @param integer $newsletter
     *
     * @return Member
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
     * @param \AppBundle\Entity\Mitglieder\MemRehabilitationCertificate $rehabilitationcertificate
     *
     * @return Member
     */
    public function addRehabilitationcertificate(\AppBundle\Entity\Mitglieder\MemRehabilitationCertificate $rehabilitationcertificate)
    {
        $rehabilitationcertificate->setMember($this);
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
    }

    /**
     * Remove rehabilitationcertificate
     *
     * @param \AppBundle\Entity\Mitglieder\MemRehabilitationCertificate $rehabilitationcertificate
     */
    public function removeRehabilitationcertificate(\AppBundle\Entity\Mitglieder\MemRehabilitationCertificate $rehabilitationcertificate)
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
     * @param \AppBundle\Entity\Mitglieder\MemPhoneNumber $phonenumber
     *
     * @return Member
     */
    public function addPhonenumber(\AppBundle\Entity\Mitglieder\MemPhoneNumber $phonenumber)
    {
        $phonenumber->setMember($this);
        $this->phonenumber[] = $phonenumber;

        return $this;
    }

    /**
     * Remove phonenumber
     *
     * @param \AppBundle\Entity\Mitglieder\MemPhoneNumber $phonenumber
     */
    public function removePhonenumber(\AppBundle\Entity\Mitglieder\MemPhoneNumber $phonenumber)
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
     * @param \AppBundle\Entity\Mitglieder\Member_Sportsgroup $sportsgroup
     *
     * @return Member
     */
    public function addSportsgroup(\AppBundle\Entity\Mitglieder\Member_Sportsgroup $sportsgroup)
    {
        $sportsgroup->setMember($this);
        $this->sportsgroup[] = $sportsgroup;

        return $this;
    }

    /**
     * Remove sportsgroup
     *
     * @param \AppBundle\Entity\Mitglieder\Member_Sportsgroup $sportsgroup
     */
    public function removeSportsgroup(\AppBundle\Entity\Mitglieder\Member_Sportsgroup $sportsgroup)
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
     * Add due
     *
     * @param \AppBundle\Entity\Mitglieder\Member_Dues $due
     *
     * @return Member
     */
    public function addDue(\AppBundle\Entity\Mitglieder\Member_Dues $due)
    {
        $due->setMember($this);
        $this->due[] = $due;

        return $this;
    }

    /**
     * Remove due
     *
     * @param \AppBundle\Entity\Mitglieder\Member_Dues $due
     */
    public function removeDue(\AppBundle\Entity\Mitglieder\Member_Dues $due)
    {
        $this->due->removeElement($due);
    }

    /**
     * Get due
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDue()
    {
        return $this->due;
    }

    /**
     * Add duespayed
     *
     * @param \AppBundle\Entity\Mitglieder\MemDuesPayed $duespayed
     *
     * @return Member
     */
    public function addDuespayed(\AppBundle\Entity\Mitglieder\MemDuesPayed $duespayed)
    {
        $this->duespayed[] = $duespayed;

        return $this;
    }

    /**
     * Remove duespayed
     *
     * @param \AppBundle\Entity\Mitglieder\MemDuesPayed $duespayed
     */
    public function removeDuespayed(\AppBundle\Entity\Mitglieder\MemDuesPayed $duespayed)
    {
        $this->duespayed->removeElement($duespayed);
    }

    /**
     * Get duespayed
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDuespayed()
    {
        return $this->duespayed;
    }
}
