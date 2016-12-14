<?php



namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerFocus")
  */
class TrainerFocus {
    
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
      * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $tfid;
        
     /**
     * @ORM\Column(type="integer") 
     * 
     */
    protected $trainerid;
    
     /**
      *  @ORM\Column(type="string")
      *  @Assert\NotBlank()
      *  @Assert\length(max=255)
      */
    protected $theme;

    /**
    * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="theme")
    * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
    */
   private $trainer;

    /**
     * Set tfid
     *
     * @param string $tfid
     *
     * @return TrainerFocus
     */
    public function setTfid($tfid)
    {
        $this->tfid = $tfid;

        return $this;
    }

    /**
     * Get tfid
     *
     * @return string
     */
    public function getTfid()
    {
        return $this->tfid;
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
}
