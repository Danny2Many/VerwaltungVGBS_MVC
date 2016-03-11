<?php

namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerFocus")
 */
class TrainerFocus{
    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="focus")
     * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
     */
    protected $trainer;
    
    /**
     * @ORM\Column(type="integer")     
     */    
    protected $trainerid;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $focus;
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO") 
     */ 
    protected $tfid;









    /**
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return TrainerFocus
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
     * Set focus
     *
     * @param string $focus
     *
     * @return TrainerFocus
     */
    public function setFocus($focus)
    {
        $this->focus = $focus;

        return $this;
    }

    /**
     * Get focus
     *
     * @return string
     */
    public function getFocus()
    {
        return $this->focus;
    }

    /**
     * Set trainer
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainer
     *
     * @return TrainerFocus
     */
    public function setTrainer(\AppBundle\Entity\Trainer\Trainer $trainer = null)
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * Get trainer
     *
     * @return \AppBundle\Entity\Trainer\Trainer
     */
    public function getTrainer()
    {
        return $this->trainer;
    }

 

   

    /**
     * Get tfid
     *
     * @return integer
     */
    public function getTfid()
    {
        return $this->tfid;
    }
}
