<?php

namespace AppBundle\Entity\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="Stocktaking")
 */

class Stocktaking {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $stockid;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\length(max=5)
     */
    protected $quantity;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $stockdate;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $state;
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Room", inversedBy="stocktaking")
     * @ORM\JoinColumn(name="roomid",referencedColumnName="roomid")
     */
    protected $location;
    
    /**
    * @ORM\Column(type="integer")
    */
   protected $invid;
    
    /**
     * @ORM\ManyToOne(targetEntity="Inventory", inversedBy="stocktaking")
     * @ORM\JoinColumn(name="invid", referencedColumnName="invid")
     */
   private $inventory;

    /**
     * Get stockid
     *
     * @return integer
     */
    public function getStockid()
    {
        return $this->stockid;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Stocktaking
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set stockdate
     *
     * @param \DateTime $stockdate
     *
     * @return Stocktaking
     */
    public function setStockdate($stockdate)
    {
        $this->stockdate = $stockdate;

        return $this;
    }

    /**
     * Get stockdate
     *
     * @return \DateTime
     */
    public function getStockdate()
    {
        return $this->stockdate;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Stocktaking
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
    
    
    
    public function setInvid($invid)
    {
        $this->invid = $invid;

        return $this;
    }

    public function getInvid()
    {
        return $this->invid;
    }

    /**
     * Set inventory
     *
     * @param \AppBundle\Entity\Inventory\Inventory $inventory
     *
     * @return Stocktaking
     */
    public function setInventory(\AppBundle\Entity\Inventory\Inventory $inventory = null)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return \AppBundle\Entity\Inventory\Inventory
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set roomid
     *
     * @param \AppBundle\Entity\Room $roomid
     *
     * @return Stocktaking
     */
    public function setLocation(\AppBundle\Entity\Room $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get roomid
     *
     * @return \AppBundle\Entity\Room
     */
    public function getLocation()
    {
        return $this->location;
    }
}
