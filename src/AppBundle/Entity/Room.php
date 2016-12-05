<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="Room")
 */

class Room {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $roomid;
    
    /**
     *@ORM\Column (type="string")
     * @Assert\NotBlank()
     * @Assert\length(max=100)
     */
    protected $roomname;
    
    /**
     * @ORM\Column (type="string")
     */
    protected $locid;
    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Inventory\Stocktaking", mappedBy="location",cascade={"persist"})
     */  
    private $stocktaking;
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Location", inversedBy="room")
     * @ORM\JoinColumn(name="locid",referencedColumnName="locid")
     */  
    private $location;
    
    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Sportsgroup", mappedBy="room")
     */
    private $sportsgroup;
    
    public function getRoomID()
    {
     return $this->roomid;
    }
    
    public function setRoomID($roomid)
    {
     $this->roomid=$roomid;
    }
    
    public function getRoomname()
    {
     return $this->roomname;
    }
    
    public function setRoomname($roomname)
    {
     $this->roomname=$roomname;
    }
  
   public function getLocID()
    {
     return $this->locid;
    }
    
    public function setLocID($locid)
    {
     $this->locid=$locid;
    }

   

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocktaking = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stocktaking
     *
     * @param \AppBundle\Entity\Inventory\Stocktaking $stocktaking
     *
     * @return Room
     */
    public function addStocktaking(\AppBundle\Entity\Inventory\Stocktaking $stocktaking)
    {
        $this->stocktaking[] = $stocktaking;

        return $this;
    }

    /**
     * Remove stocktaking
     *
     * @param \AppBundle\Entity\Inventory\Stocktaking $stocktaking
     */
    public function removeStocktaking(\AppBundle\Entity\Inventory\Stocktaking $stocktaking)
    {
        $this->stocktaking->removeElement($stocktaking);
    }

    /**
     * Get stocktaking
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStocktaking()
    {
        return $this->stocktaking;
    }

    

    /**
     * Set location
     *
     * @param \AppBundle\Entity\Location $location
     *
     * @return Room
     */
    public function setLocation(\AppBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add sportsgroup
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroup
     *
     * @return Room
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
     * Get sportsgroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSportsgroup()
    {
        return $this->sportsgroup;
    }
}
