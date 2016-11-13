<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

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
     * @ORM\Column(type="float")
     */
    protected $price;
    
  /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    protected $custom;
    
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $validfrom;
    
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $validto;

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
     * Set price
     *
     * @param float $price
     *
     * @return Dues
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set custom
     *
     * @param integer $custom
     *
     * @return Dues
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Get custom
     *
     * @return integer
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * Set validfrom
     *
     * @param \DateTime $validfrom
     *
     * @return Dues
     */
    public function setValidfrom($validfrom)
    {
        $this->validfrom = $validfrom;

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
     * @return Dues
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->member = new \Doctrine\Common\Collections\ArrayCollection();
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
}
