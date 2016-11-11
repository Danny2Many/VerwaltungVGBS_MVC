<?php

namespace AppBundle\Entity\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Inventory")
 */

class Inventory 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
 protected $invid;
 
    /**
     * @ORM\Column(type="string")
     */
 protected $objectname;
 
    /**
     * @ORM\Column(type="string")
     */
 protected $description;
 
    /**
     * @ORM\OneToMany(targetEntity="ObjectOrder", mappedBy="inventory",cascade={"persist"})
     */
 private $order;
 
    /**
     * @ORM\OneToMany(targetEntity="Stocktaking", mappedBy="inventory",cascade={"persist"})
     */
 private $stocktaking;
  
   

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stocktaking = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get invid
     *
     * @return integer
     */
    public function getInvid()
    {
        return $this->invid;
    }

    /**
     * Set objectname
     *
     * @param string $objectname
     *
     * @return Inventory
     */
    public function setObjectname($objectname)
    {
        $this->objectname = $objectname;

        return $this;
    }

    /**
     * Get objectname
     *
     * @return string
     */
    public function getObjectname()
    {
        return $this->objectname;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Inventory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Inventory\ObjectOrder $order
     *
     * @return Inventory
     */
    public function addOrder(\AppBundle\Entity\Inventory\ObjectOrder $order)
    {
        $order->setInventory($this);
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Inventory\ObjectOrder $order
     */
    public function removeOrder(\AppBundle\Entity\Inventory\ObjectOrder $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add stocktaking
     *
     * @param \AppBundle\Entity\Inventory\Stocktaking $stocktaking
     *
     * @return Inventory
     */
    public function addStocktaking(\AppBundle\Entity\Inventory\Stocktaking $stocktaking)
    {
                $stocktaking->setInventory($this);

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
    
//   public function addRoom(\AppBundle\Entity\Room $room)
//    {
//        $this->room[] = $room;
//
//        return $this;
//    }
//
//    public function removeRoom(\AppBundle\Entity\Room $room)
//    {
//        $this->room->removeElement($room);
//    }
//
//    public function getRoom()
//    {
//        return $this->room;
//    } 
//    
}
