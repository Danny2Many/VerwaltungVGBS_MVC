<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer_NonMemSportsgroupSub")
 * @ORM\HasLifecycleCallbacks()
 */
class Trainer_NonMemSportsgroupSub {
   protected $substitute;
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")  
    */
    protected $trainerid;
    /**
    * @ORM\Id
    * @ORM\Column(type="string")  
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

    public function __toString(){
//    return (string) $this->nmemid.'id/'.$this->sgid.'/Nichtmitglieder\NonMember_Sportsgroup';
    return (string) 'a/a/Nichtmitglieder\Trainer_NonMemSportsgroupSub';
}
    
    
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
     * Add trainerid
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainerid
     *
     * @return Trainer_NonMemSportsgroupSub
     */
    public function addTrainerid(\AppBundle\Entity\Trainer\Trainer $trainerid)
    {
        $this->trainerid[] = $trainerid;

        return $this;
    }

    /**
     * Remove trainerid
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainerid
     */
    public function removeTrainerid(\AppBundle\Entity\Trainer\Trainer $trainerid)
    {
        $this->trainerid->removeElement($trainerid);
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
    
    public function setSubstitute($substitute)
    {   $substitute->setTrainerid($this->trainerid);
        $this->substitute = $substitute;

        return $this;
    }

    public function getSubstitute()
    {
        return $this->substitute;
    }

    public function addSubstitute(\AppBundle\Entity\Trainer\Trainer $substitute)
    {
        $substitute->setTrainerid($this->trainerid);
        $this->substitute->add($substitute);

        return $this;
        
    }

    public function removeSubstitute(\AppBundle\Entity\Trainer\Trainer $substitute)
    {
        $this->substitute->removeElement($substitute);
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
