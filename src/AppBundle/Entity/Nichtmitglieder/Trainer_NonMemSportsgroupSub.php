<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer_NonMemSportsgroupSub")
 * @ORM\HasLifecycleCallbacks()
 */
class Trainer_NonMemSportsgroupSub {
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")  
    */
    protected $trainerid;
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")  
    */
    protected $sgid;
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
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return Trainer_NonMemSportsgroupSub
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
     * Set sgid
     *
     * @param integer $sgid
     *
     * @return Trainer_NonMemSportsgroupSub
     */
    public function setSgid($sgid)
    {
        $this->sgid = $sgid;

        return $this;
    }

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
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return Trainer_NonMemSportsgroupSub
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
     * @param string $validto
     *
     * @return Trainer_NonMemSportsgroupSub
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
