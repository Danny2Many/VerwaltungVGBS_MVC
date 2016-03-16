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
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="tfocus")
     * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
     */
    private $trainer;
    
    
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $tfid;
    
     /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $trainerid;
    
     /**
      *  
      *  @ORM\Column(type="string")
      * 
      */
    protected $tfocus;

    

   

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
     * Set tfocus
     *
     * @param string $tfocus
     *
     * @return TrainerFocus
     */
    public function setTfocus($tfocus)
    {
        $this->tfocus = $tfocus;

        return $this;
    }

    /**
     * Get tfocus
     *
     * @return string
     */
    public function getTfocus()
    {
        return $this->tfocus;
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
