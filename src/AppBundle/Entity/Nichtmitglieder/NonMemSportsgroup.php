<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemSportsgroup")
 * @ORM\HasLifecycleCallbacks()
 */
class NonMemSportsgroup {
//    
//    /**
//    * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
//    * @ORM\JoinTable(name="NonMemSportsgroup_Section",
//    * joinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")},
//    * inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
//    */ 
//    protected $section; 

    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     */
    protected $sgid;
    
    public function __toString() {
            return $this->sgid.'/sg/Nichtmitglieder\NonMemSportsgroup'; 
        }
      protected $bssaid;
      protected $bssacert;
      protected $trainer;
      protected $substitute;
      /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $day;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * 
     */
    protected $time;
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $info;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $roomid;
    

    /**
     * @ORM\Column(type="integer") 
     */
    protected $trainerid;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $token;
    
    /**
    * @ORM\Column(type="integer")
    */
    protected $capacity;

    /**
     * @ORM\Id
    * @ORM\Column(type="string")
    */
    protected $validfrom;

    /**
    * @ORM\Column(type="string")
    */
    protected $validto;

    /** @ORM\PostLoad */
    public function __construct() {
        
    //        $this->sportsgroup = new ArrayCollection();
        $this->bssacert = new ArrayCollection();
    }

    /**
     * Get sgid
     *
     * @return integer
     */
    public function getSgid()
    {
        return $this->sgid;
    }
    /**
     * Set sgid
     *
     * @param integer $sgid
     *
     * @return NonMemSportsgroup
     */
    public function setSgid($sgid)
    {
        $this->sgid = $sgid;

        return $this;
    }
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return NonMemSportsgroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set day
     *
     * @param string $day
     *
     * @return NonMemSportsgroup
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return NonMemSportsgroup
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return NonMemSportsgroup
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set roomid
     *
     * @param integer $roomid
     *
     * @return NonMemSportsgroup
     */
    public function setRoomid($roomid)
    {
        $this->roomid = $roomid;

        return $this;
    }

    /**
     * Get roomid
     *
     * @return integer
     */
    public function getRoomid()
    {
        return $this->roomid;
    }

    /**
     * Add trainerid
     *
     * @param \AppBundle\Entity\Rooms $roomid
     *
     * @return NonMemSportsgroup
     */
    public function addRoomid(\AppBundle\Entity\Rooms $roomid)
    {
        $this->roomid[] = $roomid;

        return $this;
    }

    /**
     * Remove roomid
     *
     * @param \AppBundle\Entity\Rooms $roomid
     */
    public function removeRoomid(\AppBundle\Entity\Rooms $roomid)
    {
        $this->trainerid->removeElement($roomid);
    }
    
    /**
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return NonMemSportsgroup
     */
    public function setTrainerid($trainerid)
    {
        $this->trainerid = $trainerid;

        return $this;
    }
    public function addRoomdid(\AppBundle\Entity\Rooms $rooms)
    {
        $rooms->setNMemID($this->nmemid);
        $this->rehabilitationcertificate->add($rooms);

        return $this;
        
    }

 
    public function removeRehabilitationcertificate(\AppBundle\Entity\Nichtmitglieder\NonMemRehabilitationCertificate $rehabilitationcertificate)
    {
        $this->rehabilitationcertificate->removeElement($rehabilitationcertificate);
    }
    /**
     * Get trainerid
     *
     * @return integer
     */
    public function getTrainerid()
    {
        return $this->trainerid;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return NonMemSportsgroup
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Add section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return NonMemSportsgroup
     */
    public function addSection(\AppBundle\Entity\Section $section)
    {
        $this->section[] = $section;

        return $this;
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
 * @ORM\PrePersist
 */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * Get recorded
     *
     * @return \DateTime
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
     * @return NonMemSportsgroup
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
     * Add trainerid
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainerid
     *
     * @return NonMemSportsgroup
     */
    public function addTrainerid(\AppBundle\Entity\Trainer\Trainer $trainerid)
    {
        $this->trainerid[] = $trainerid;

        return $this;
    }

    /**
     * Remove trainerid
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainerid
     */
    public function removeTrainerid(\AppBundle\Entity\Trainer\Trainer $trainerid)
    {
        $this->trainerid->removeElement($trainerid);
    }

    /**
     * Set bssaid
     *
     * @param integer $bssaid
     *
     * @return NonMemSportsgroup
     */
    public function setBssaid($bssaid)
    {
        $this->bssaid = $bssaid;

        return $this;
    }

    /**
     * Get bssaid
     *
     * @return integer
     */
    public function getBssaid()
    {
        return $this->bssaid;
    }
    public function setSubstitute($substitute)
    {   $substitute->setSgid($this->sgid);
        $this->substitute = $substitute;

        return $this;
    }

   
    public function getSubstitute()
    {
        return $this->substitute;
    }


    public function addSubstitute(\AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub $substitute)
    {
        $substitute->setSgid($this->sgid);
        $this->substitute->add($substitute);

        return $this;
        
    }

 
    public function removeSubstitute(\AppBundle\Entity\Nichtmitglieder\Trainer_NonMemSportsgroupSub $substitute)
    {
        $this->substitute->removeElement($substitute);
    }
    public function setTrainer($trainer)
    {   $trainer->setSgid($this->sgid);
        $this->trainer = $trainer;

        return $this;
    }

   
    public function getTrainer()
    {
        return $this->trainer;
    }


    public function addTrainer(\AppBundle\Entity\Trainer\Trainer $trainer)
    {
        $trainer->setSgid($this->sgid);
        $this->trainer->add($trainer);

        return $this;
        
    }

 
    public function removeTrainer(\AppBundle\Entity\Trainer\Trainer $trainer)
    {
        $this->trainer->removeElement($trainer);
    }
    
    /**
    * Set Bssacert
    *
    * @param integer $bssacert
    *
    * @return NonMemPhoneNumber
    */
    public function setBssacert($bssacert)
    {   
        $this->bssacert = $bssacert;

        return $this;
    }

   /**
    * Get Bssacert
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBssacert()
    {
        return $this->bssacert;
    }


    public function addBssacert(\AppBundle\Entity\BSSACert $bssacert)
    {
        $bssacert->setSgid($this->sgid);
        $this->bssacert->add($bssacert);

        return $this;
        
    }

 
    public function removeBssacert(\AppBundle\Entity\BSSACert $bssacert)
    {
        $this->bssacert->removeElement($bssacert);
    }
 /**
     * Set validfrom
     *
     * @param  string $validfrom
     *
     * @return NonMemSportsgroup
     */
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
     * @param  string $validto
     *
     * @return NonMemSportsgroup
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

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return NonMemSportsgroup
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }
}
