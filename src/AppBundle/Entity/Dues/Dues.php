<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity\Dues;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Dues")
 * 
 */
class Dues {
    
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") 
     * 
     */
    protected $dueid;
    

    
   /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * 
     */
    protected $name;
    
    
     /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Mitglieder\Member_Dues", mappedBy="due")
     */
    protected $member;
    
         /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Dues\Price", mappedBy="due")
     */
    protected $price;
    
  /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    protected $description;
    
  /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    protected $ifcustom;
    
    

    /**
     * Get dueid
     *
     * @return integer
     */
    public function getDueid()
    {
        return $this->dueid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Dues
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
     * Constructor
     */
    public function __construct()
    {
        $this->member = new \Doctrine\Common\Collections\ArrayCollection();
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add member
     *
     * @param \AppBundle\Entity\Mitglieder\Member_Dues $member
     *
     * @return Dues
     */
    public function addMember(\AppBundle\Entity\Mitglieder\Member_Dues $member)
    {
        $this->member[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \AppBundle\Entity\Mitglieder\Member_Dues $member
     */
    public function removeMember(\AppBundle\Entity\Mitglieder\Member_Dues $member)
    {
        $this->member->removeElement($member);
    }

    /**
     * Get member
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set ifcustom
     *
     * @param integer $ifcustom
     *
     * @return Dues
     */
    public function setIfcustom($ifcustom)
    {
        $this->ifcustom = $ifcustom;

        return $this;
    }

    /**
     * Get ifcustom
     *
     * @return integer
     */
    public function getIfcustom()
    {
        return $this->ifcustom;
    }

   

    /**
     * Add price
     *
     * @param \AppBundle\Entity\Dues\Price $price
     *
     * @return Dues
     */
    public function addPrice(\AppBundle\Entity\Dues\Price $price)
    {
        $this->price[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \AppBundle\Entity\Dues\Price $price
     */
    public function removePrice(\AppBundle\Entity\Dues\Price $price)
    {
        $this->price->removeElement($price);
    }

    /**
     * Get price
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrice()
    {
        return $this->price;
    }

   

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Dues
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
}
