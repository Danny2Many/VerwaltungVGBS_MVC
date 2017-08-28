<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Sportsgroup")
 */
class Sportsgroup {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $sgid;
    
//    /**
//     * @OneToOne(targetEntity="BSSACert")
//     * @JoinColumn(name="bssaid", referencedColumnName="bssaid")
//     */
//      protected $bssacert;
//      protected $trainer;
//      protected $substitute;
      
    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup", mappedBy="sportsgroup")
     */
    protected $memsubscriber;
    
    

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    protected $day;
    
    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     */
    protected $time;
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $info;
    
    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $token;
    
    /**
    * @ORM\Column(type="integer")
    */
    protected $capacity;

    /**
    * @ORM\Column(type="string")
    */
    protected $type;
    
    /**
    * @ORM\Column(type="integer")
    */
    protected $roomid;
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Room",inversedBy="sportsgroup")
     * @ORM\JoinColumn(name="roomid",referencedColumnName="roomid") 
     */
    private $room;
    
    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Trainer\Trainer", mappedBy="sportsgroupsub")
     * @ORM\JoinTable(name="Trainer_SportsgroupSub", joinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")})
     */
    private $trainersub;

    /**
    * @ORM\Column(type="integer")
    */
    protected $trainerid;

    /**
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\BSSACert",inversedBy="sportsgroup")
     * @ORM\JoinColumn(name="bssaid",referencedColumnName="bssaid")
     */
    private $bssacert;
    
    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Trainer\Trainer",mappedBy="sportsgroup")
     * 
     */
    private $trainer;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    //    $this->memsubscriber = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trainersub= new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set sgid
     *
     * @param integer $sgid
     *
     * @return Sportsgroup
     */
    public function setSgid($sgid)
    {
        $this->sgid = $sgid;

        return $this;
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
     * Set name
     *
     * @param string $name
     *
     * @return Sportsgroup
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
     * @param integer $day
     *
     * @return Sportsgroup
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
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
     * @return Sportsgroup
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
     * @return Sportsgroup
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
     * Set token
     *
     * @param string $token
     *
     * @return Sportsgroup
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
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return Sportsgroup
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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Sportsgroup
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add memsubscriber
     *
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memsubscriber
     *
     * @return Sportsgroup
     */
    public function addMemsubscriber(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memsubscriber)
    {
        $this->memsubscriber[] = $memsubscriber;

        return $this;
    }

    /**
     * Remove memsubscriber
     *
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memsubscriber
     */
    public function removeMemsubscriber(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memsubscriber)
    {
        $this->memsubscriber->removeElement($memsubscriber);
    }

    /**
     * Get memsubscriber
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMemsubscriber()
    {
        return $this->memsubscriber;
    }

   
    /**
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return Sportsgroup
     */
    public function setRoom(\AppBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \AppBundle\Entity\Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Add trainersub
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainersub
     *
     * @return Sportsgroup
     */
public function addTrainersub(\AppBundle\Entity\Trainer\Trainer $trainersub)
    {
        $trainersub->addSportsgroupsub($this);
        $this->trainersub[] = $trainersub;

        return $this;
    }
    
   /**
     * Remove trainersub
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainersub
     */
    public function removeTrainersub(\AppBundle\Entity\Trainer\Trainer $trainersub)
    {
        $this->trainersub->removeElement($trainersub);
    }

    /**
     * Get trainersub
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrainersub()
    {
        return $this->trainersub;
    }
    
    public function getTrainerid()
    {
        return $this->trainerid;
    }

     /**
     * Add bssa
     *
     * @param \AppBundle\Entity\BSSACert $bssa
     *
     * @return Sportsgroup
     */
    public function addBssacert(\AppBundle\Entity\BSSACert $bssa)
    {
        $bssa->setSportsgroup($this);
        $this->bssacert[] = $bssa;

        return $this;
    }
    
   /**
     * Remove bssa
     *
     * @param \AppBundle\Entity\BSSACert $bssa
     */
    public function removeBssacert(\AppBundle\Entity\BSSACert $bssa)
    {
        $this->bssacert->removeElement($bssa);
    }
    
    public function getBssacert()
    {
        return $this->bssacert;
    }
    
    public function addTrainer(\AppBundle\Entity\Trainer\Trainer $trainer)
    {
     $trainer->setSportsgroup($this);
     $this->trainer[]=$trainer;
    }
    
    public function removeTrainer(\AppBundle\Entity\Trainer\Trainer $trainer)
    {
     $this->trainer->removeElement($trainer);
    }
    
    public function getTrainer()
    {
        return $this->trainer;
    }
    
    public function setRoomid($roomid)
    {
        $this->roomid = $roomid;

        return $this;
    }

    public function getRoomid()
    {
        return $this->roomid;
    }

    /**
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return Sportsgroup
     */
    public function setTrainerid($trainerid)
    {
        $this->trainerid = $trainerid;

        return $this;
    }

    /**
     * Set bssacert
     *
     * @param \AppBundle\Entity\BSSACert $bssacert
     *
     * @return Sportsgroup
     */
    public function setBssacert(\AppBundle\Entity\BSSACert $bssacert = null)
    {
        $this->bssacert = $bssacert;

        return $this;
    }
    
    function getPeriodOfRest() {
        return $this->periodOfRest;
    }




}
