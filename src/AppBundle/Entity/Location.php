<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Location")
 */
class Location 
{
 /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue(strategy="AUTO")
  */   
protected $locid;

/**
 *@ORM\Column (type="string")
 * @Assert\NotBlank()
 * @Assert\length(max=100)
*/
protected $locname;    

/**
 *@ORM\Column (type="string")
 * @Assert\NotBlank()
 * @Assert\length(max=255)
*/
protected $streetaddress;

/**
*@ORM\Column (type="integer")
*/
protected $postcode;

/**
 * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Room", mappedBy="location",cascade={"persist"})
 * @ORM\JoinColumn(name="locid",referencedColumnName="locid")
 */
protected $room;


public function getLocID()
    {
     return $this->locid;
    }
 
public function setLocID($locid)
    {
    $this->locid=$locid;
    }

public function getLocName()
    {
     return $this->locname;
    }
 
public function setLocName($locname)
    {
    $this->locname=$locname;
    }

public function getStreetAddress()
    {
     return $this->streetaddress;
    }
 
public function setStreetaddress($streetaddress)
    {
    $this->streetaddress=$streetaddress;
    }
    
public function getPostcode()
    {
     return $this->postcode;
    }
 
public function setPostcode($postcode)
    {
    $this->postcode=$postcode;
    }
 
    

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->room = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return Location
     */
    public function addRoom(\AppBundle\Entity\Room $room)
    {
        $room->setLocation($this);
        $this->room[] = $room;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \AppBundle\Entity\Room $room
     */
    public function removeRoom(\AppBundle\Entity\Room $room)
    {
        $this->room->removeElement($room);
    }

    /**
     * Get room
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoom()
    {
        return $this->room;
    }
}
