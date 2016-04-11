<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
//    
//    /**
//     * @ORM\Column(type="string")
//        * @Assert\NotBlank()
//     * @Assert\Choice(choices = {"Mitglieder", "Nichtmitglieder"}, message = "Bitte wählen Sie eine gültige Kategorie.")
//     */
//    protected $category;
//    
//    /**
//     * @ORM\Column(type="string")
//     */
//    protected $type;
//    
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
     * @ORM\Column(type="time")
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
    
   
    protected $trainerid;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $token;
    
     
    protected $bssaid;
    /**
     * @ORM\Id
    * @ORM\Column(type="date")
    */
    protected $validfrom;

    /**
    * @ORM\Column(type="date")
    */
    protected $validto;


    /**
     * Get sgid
     *
     * @return integer
     */
    public function getSgid()
    {
        return $this->sgid;
    }
//
//    /**
//     * Set category
//     *
//     * @param string $category
//     *
//     * @return NonMemSportsgroup
//     */
//    public function setCategory($category)
//    {
//        $this->category = $category;
//
//        return $this;
//    }
//
//    /**
//     * Get category
//     *
//     * @return string
//     */
//    public function getCategory()
//    {
//        return $this->category;
//    }
//
//    /**
//     * Set type
//     *
//     * @param string $type
//     *
//     * @return NonMemSportsgroup
//     */
//    public function setType($type)
//    {
//        $this->type = $type;
//
//        return $this;
//    }
//
//    /**
//     * Get type
//     *
//     * @return string
//     */
//    public function getType()
//    {
//        return $this->type;
//    }

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
     * Constructor
     */
    public function __construct()
    {
        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set validfrom
     *
     * @param \DateTime $validfrom
     *
     * @return NonMemSportsgroup
     */
    public function setValidfrom($validfrom)
    {
        $now= new \DateTime();
        $this->validform = $now->format('Y');

        return $this;
    }

    /**
     * Get validfrom
     *
     * @return \DateTime
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }

    /**
     * Set validto
     *
     * @param \DateTime $validto
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
     * @return \DateTime
     */
    public function getValidto()
    {
        return $this->validto;
    }
}
