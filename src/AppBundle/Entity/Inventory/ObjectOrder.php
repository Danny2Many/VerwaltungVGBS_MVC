<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity\Inventory;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ObjectOrder")
 */
class ObjectOrder {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
   protected $orderid;
   
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\length(max=25)
     */
   protected $invoicenumber;
   
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
   protected $orderdate;
   
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
   protected $orderprice;
   
    /**
     * @ORM\Column(type="string")
     * @Assert\length(max=100)
     */
   protected $company;
   
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\length(max=5)
     */
   protected $quantity;
   
   /**
    * @ORM\Column(type="integer")
    */
   protected $invid;
  
   /**
    * @ORM\ManyToOne(targetEntity="Inventory", inversedBy="order")
    * @ORM\JoinColumn(name="invid", referencedColumnName="invid")
    */
   private $inventory;
   

    /**
     * Get orderid
     *
     * @return integer
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set invoicenumber
     *
     * @param string $invoicenumber
     *
     * @return ObjectOrder
     */
    public function setInvoicenumber($invoicenumber)
    {
        $this->invoicenumber = $invoicenumber;

        return $this;
    }

    /**
     * Get invoicenumber
     *
     * @return string
     */
    public function getInvoicenumber()
    {
        return $this->invoicenumber;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     *
     * @return ObjectOrder
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Set orderprice
     *
     * @param float $orderprice
     *
     * @return ObjectOrder
     */
    public function setOrderprice($orderprice)
    {
        $this->orderprice = $orderprice;

        return $this;
    }

    /**
     * Get orderprice
     *
     * @return float
     */
    public function getOrderprice()
    {
        return $this->orderprice;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return ObjectOrder
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return ObjectOrder
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
     * @return ObjectOrder
     */
    public function setInventory(\AppBundle\Entity\Inventory\Inventory $inventory = null)
    {
        //$inventory->addOrder($this);
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
}
