<?php


namespace AppBundle\Entity;

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
    
    protected $rehabilitationcertificate;

    protected $phonenumber;
    

    
   
    public function __construct() {
        
//        $this->sportsgroup = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        $this->phonenumber = new ArrayCollection();;

     
    }
        
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $memid;

   
    public function __toString()
 {
  return $this->memid;
 }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * 
     */
    protected $validfrom;
    
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $validto;
   
      /**
     * @ORM\Column(type="date")
       * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $admissiondate;
    
    /**
     * @ORM\Column(type="date")
       * 
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $quitdate;
    
    
  
      /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     * @Assert\Choice(choices = {"aktiv", "inaktiv"}, message = "Bitte wählen Sie einen gültigen Status.")
     */
    protected $state;
    
      
    
       /**
     * @ORM\Column(type="date")
        * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $admissionconfirmation;
    
    
      
    
       /**
     * @ORM\Column(type="binary")
        * @Assert\NotBlank()
     * 
     */
    protected $decreaseddues;
    
    /**
     * @ORM\Column(type="binary")
        * 
     * 
     */
    protected $newsletter; 
    
    
      /**
     * @ORM\Column(type="string")
     */
    protected $additionalinfo;

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
     * @return string
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

    /**
     * Get admissiondate
     *
     * @return \DateTime
     */
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
     * @return \DateTime
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
     * Set memid
     *
     * @param string $memid
     *
     * @return Member
     */
    public function setMemid($memid)
    {
        $this->memid = $memid;

        return $this;
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
     * @param binary $newsletter
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
     * @return binary
     */
    public function getNewsletter()
    {
        return array($this->newsletter);
    }

    

 

   
    public function setValidfrom($validfrom)
    {
        
        $this->validfrom = $validfrom;

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
     * @return Member
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

   
    
 
    
    
    public function addRehabilitationcertificate(\AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate)
    {
  
        $rehabilitationcertificate->setMemid($this->memid);
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
        
    }

   
    public function removeRehabilitationcertificate(\AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate)
    {
        $this->rehabilitationcertificate->removeElement($rehabilitationcertificate);
    }

    
    public function getRehabilitationcertificate()
    {
        return $this->rehabilitationcertificate;
    }
    



    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
     


 public function addPhonenumber(\AppBundle\Entity\MemPhoneNumber $phonenumber)
    {               
        $phonenumber->setMemid($this->memid);
        $this->phonenumber[] = $phonenumber;

        return $this;
    }

    
    public function removePhonenumber(\AppBundle\Entity\MemPhoneNumber $phonenumber)
    {
        $this->phonenumber->removeElement($phonenumber);
    }
}
