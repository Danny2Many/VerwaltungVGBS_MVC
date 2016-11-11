<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

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
     */
    protected $roomname;
    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Inventory\Stocktaking", mappedBy="location",cascade={"persist"})
     */  
    private $stocktaking;
    
    
    
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
}
