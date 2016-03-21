<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\HealthData;


/**
 * @ORM\Entity
 * @ORM\Table(name="Member")
 */
class Member extends HealthData
{
    

      /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\MemSportsgroup")
     * @ORM\JoinTable(name="Member_Sportsgroup",
 *      joinColumns={@ORM\JoinColumn(name="memid", referencedColumnName="memid")},
 *      inverseJoinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")})
     */

    protected $sportsgroup; 
    
        /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
     * @ORM\JoinTable(name="Member_Section",
 *      joinColumns={@ORM\JoinColumn(name="memid", referencedColumnName="memid")},
 *      inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
     */

    protected $section;
    
    
    /**
     * @ORM\OneToMany(targetEntity="MemRehabilitationCertificate", mappedBy="member", cascade={"all"})
     */
    protected $rehabilitationcertificate;


    
    /**
     * @ORM\OneToMany(targetEntity="MemMonthlyDues", mappedBy="member", cascade={"all"})
     */
    protected $monthlydues;
    
    
    /**
     * @ORM\OneToMany(targetEntity="MemYearInfo", mappedBy="member", cascade={"all"})
     */
    protected $yearinfo;
    
    
    
    public function __construct() {
        
        $this->sportsgroup = new ArrayCollection();
        $this->rehabilitationcertificate = new ArrayCollection();
        $this->phonenumber = new ArrayCollection();
        $this->monthlydues = new ArrayCollection();
        $this->section = new ArrayCollection();
    }
    
    
   

    
    
    /**
     * Add sportsgroup
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroup
     *
     * @return Member
     */
    public function addSportsgroup(\AppBundle\Entity\Sportsgroup $sportsgroup)
    {
        $this->sportsgroup[] = $sportsgroup;

        return $this;
    }

    /**
     * Remove sportsgroup
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroup
     */
    public function removeSportsgroup(\AppBundle\Entity\Sportsgroup $sportsgroup)
    {
        $this->sportsgroup->removeElement($sportsgroup);
    }

    /**
     * Get sportsgroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSportsgroup()
    {
        return $this->sportsgroup;
    }
     
/**
 * Set categories
 * @param \Doctrine\Common\Collections\Collection $categories
 *
 * @return Post
 */
public function setSportsgroup($sportsgroup)
{

    if(!is_array($sportsgroup))
    {
        $sportsgroup = array($sportsgroup);
    }
    $this->sportsgroup = $sportsgroup;

    return $this;
}

    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $memid;

   
    
      /**
     * @ORM\Column(type="date")
       * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $admissiondate;
    
  
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
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * @Assert\Choice(choices = {"kein", "(verminderter Beitrag)"}, message = "Bitte wählen Sie eine gültigen option.")
     */
    protected $decreaseddues;
    
     
    
    
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
     * Set stresstest
     *
     * @param string $stresstest
     *
     * @return Member
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
     * Add section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Member
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
     * Add rehabilitationcertificate
     *
     * @param \AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate
     *
     * @return Member
     */
    public function addRehabilitationcertificate(\AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate)
    {
  
        $rehabilitationcertificate->setMember($this);
        $this->rehabilitationcertificate[] = $rehabilitationcertificate;

        return $this;
        
    }

    /**
     * Remove rehabilitationcertificate
     *
     * @param \AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate
     */
    public function removeRehabilitationcertificate(\AppBundle\Entity\MemRehabilitationCertificate $rehabilitationcertificate)
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
     * Add monthlydue
     *
     * @param \AppBundle\Entity\MemMonthlyDues $monthlydue
     *
     * @return Member
     */
    public function addMonthlydue(\AppBundle\Entity\MemMonthlyDues $monthlydue)
    {
        $monthlydue->setMember($this);
        $this->monthlydues[] = $monthlydue;

        return $this;
    }

    /**
     * Remove monthlydue
     *
     * @param \AppBundle\Entity\MemMonthlyDues $monthlydue
     */
    public function removeMonthlydue(\AppBundle\Entity\MemMonthlyDues $monthlydue)
    {
        $this->monthlydues->removeElement($monthlydue);
    }

    /**
     * Get monthlydues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonthlydues()
    {
        return $this->monthlydues;
    }

    /**
     * Add yearinfo
     *
     * @param \AppBundle\Entity\MemYearInfo $yearinfo
     *
     * @return Member
     */
    public function addYearinfo(\AppBundle\Entity\MemYearInfo $yearinfo)
    {
        $yearinfo->setMember($this);
        $this->yearinfo[] = $yearinfo;

        return $this;
    }

    /**
     * Remove yearinfo
     *
     * @param \AppBundle\Entity\MemYearInfo $yearinfo
     */
    public function removeYearinfo(\AppBundle\Entity\MemYearInfo $yearinfo)
    {
        $this->yearinfo->removeElement($yearinfo);
    }

    /**
     * Get yearinfo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getYearinfo()
    {
        return $this->yearinfo;
    }
}
