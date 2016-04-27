<?php



namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerFocus")
 * @ORM\HasLifecycleCallbacks()
 */
class TrainerFocus {
    
     /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $tfid;
        
     /**
     * @ORM\Column(type="string") 
     * 
     */
    protected $trainerid;
    
     /**
      *  
      *  @ORM\Column(type="string")
      * 
      */
    protected $theme;

    /**
     * @ORM\Column(type="string")
     */
    protected $validto;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $validfrom;
    
    
    public function __toString() {
        return $this->tfid.'/tf/Trainer\TrainerFocus'; 
    }

    /**
     * Set trainerid
     *
     * @param string $trainerid
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
     * @return string
     */
    public function getTrainerid()
    {
        return $this->trainerid;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return TrainerFocus
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
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
     * Set validto
     *
     * @param \DateTime $validto
     *
     * @return TrainerFocus
     */
    public function setValidto($validto)
    {
        $this->validto = $validto;

        return $this;
    }

    /**
     * Get Validto
     *
     * @return \DateTime
     */
    public function getValidto()
    {
        return $this->validto;
    }

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
     * Get tfid
     *
     * @return integer
     */
    public function getTfid()
    {
        return $this->tfid;
    }
    
    /**
     * Set tfid
     *
     * @param integer $tfid
     *
     * @return TrainerLicence
     */
    public function setTfid($tfid)
    {
        $this->tfid = $tfid;

        return $this;
    }
}
