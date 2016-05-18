<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="MemSportsgroup")
 * @ORM\HasLifecycleCallbacks()
 */
class MemSportsgroup {
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     */
    protected $sgid;
    
    public function __toString() {
            return (string) $this->sgid.'/sg/MemSportsgroup'; 
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
     * @ORM\Column(type="datetime")
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
        $this->bssacert = new ArrayCollection();
        $this->substitute = new ArrayCollection();
    }

    /**
     * Get sgid
     *
     * @return string
     */
    public function getSgid()
    {
        return $this->sgid;
    }
    /**
     * Set sgid
     *
     * @param string $sgid
     *
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * Set bssaid
     *
     * @param integer $bssaid
     *
     * @return MemSportsgroup
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


    public function addSubstitute(\AppBundle\Entity\Trainer_MemSportsgroupSub $substitute)
    {
        
        $this->substitute->add($substitute);

        return $this;
        
    }

 
    public function removeSubstitute(\AppBundle\Entity\Trainer_MemSportsgroupSub $substitute)
    {
        $this->substitute->removeElement($substitute);
    }
    public function setTrainer($trainer)
    {  
//        $trainer->setTrainerid($this->Trainerid);
        $this->trainer = $trainer;

        return $this;
    }

   
    public function getTrainer()
    {
        return $this->trainer;
    }


    public function addTrainer(\AppBundle\Entity\Trainer\Trainer $trainer)
    {
//        $trainer->setTrainerid($this->Trainerid);
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
    * @return MemPhoneNumber
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
     * @return MemSportsgroup
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
