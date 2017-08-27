<?php

namespace AppBundle\Entity\Nichtmitglieder;

/**
 * Trainer_NonMemSportsgroupSub
 */
class Trainer_NonMemSportsgroupSub
{
    /**
     * @var integer
     */
    private $trainerid;

    /**
     * @var string
     */
    private $sgid;

    /**
     * @var string
     */
    private $validfrom;

    /**
     * @var string
     */
    private $validto;


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
     * @param string $sgid
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
     * @return string
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

