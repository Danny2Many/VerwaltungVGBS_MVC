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
     * @ORM\Column(type="integer") 
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
     * @ORM\Column(type="date")
     */
    protected $deleted;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="date")
     */
    protected $recorded;   

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
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return TrainerFocus
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set recorded
     *
     * @param \DateTime $recorded
     *
     * @return TrainerFocus
     */
    public function setRecorded()
    {
        $now= new \DateTime();
        $this->recorded = $now->format('Y-m-d');

        return $this;
    }

    /**
     * Get recorded
     *
     * @return \DateTime
     */
    public function getRecorded()
    {
        return $this->recorded;
    }
}
