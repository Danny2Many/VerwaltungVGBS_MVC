<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rooms")
 * @ORM\HasLifecycleCallbacks()
 */
class Rooms {
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    */
    protected $roomid;
    /**
    * @ORM\Id
    * @ORM\Column(type="string")
    */
    protected $roomname;
    
    /**
     * @ORM\Id
    * @ORM\Column(type="string")
    */
    protected $validfrom;

    /**
    * @ORM\Column(type="string")
    */
    protected $validto;
    /**
     * Set roomid
     *
     * @param integer $roomid
     *
     * @return Rooms
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
     * Set roomname
     *
     * @param string $roomname
     *
     * @return Rooms
     */
    public function setRoomname($roomname)
    {
        $this->roomname = $roomname;

        return $this;
    }

    /**
     * Get roomname
     *
     * @return string
     */
    public function getRoomname()
    {
        return $this->roomname;
    }
     /**
     * Set validfrom
     *
     * @param  string $validfrom
     *
     * @return NonMemSportsgroup
     */
    public function setValidfrom($validfrom)
    {
        $this->validfrom = $validfrom;

        return $this;
    }
    /**
     * Get validfrom
     *
     * @return string
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }

    /**
     * Set validto
     *
     * @param  string $validto
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
     * @return string
     */
    public function getValidto()
    {
        return $this->validto;
    }
}
