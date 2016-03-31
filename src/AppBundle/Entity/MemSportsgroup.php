<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="MemSportsgroup")
 */
class MemSportsgroup {
    
     /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
     * @ORM\JoinTable(name="MemSportsgroup_Section",
 *      joinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")},
 *      inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
     */

    protected $section;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $sgid;
    
    
    
    
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * 
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
        * @Assert\NotBlank()
     * 
     */
    protected $info;
    
    /**
     * @ORM\Column(type="integer")
        * 
     * 
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
     * @param string $day
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
     * Set roomid
     *
     * @param integer $roomid
     *
     * @return Sportsgroup
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
     * @return Sportsgroup
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
     * Get section
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSection()
    {
        return $this->section;
    }
}
