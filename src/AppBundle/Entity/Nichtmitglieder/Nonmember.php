<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HealthData;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember")
 */
class Nonmember extends HealthData {

/**
* @ORM\Id
* @ORM\Column(type="integer") 
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $NMenID;    
    
/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $TrainingDate;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $TrainingConfirmation;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/  
protected $Settlement1;

/**
* @ORM\Column(type="date")
* @Assert\NotBlank()
* @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
*/
protected $Settlement2;
 


 /**
 ** @ORM\OneToMany(targetEntity="NonMemPhoneNumber", mappedBy="member", cascade={"persist"})
 */
    protected $phonenumber;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get nMenID
     *
     * @return integer
     */
    public function getNMenID()
    {
        return $this->NMenID;
    }

    /**
     * Set trainingDate
     *
     * @param \DateTime $trainingDate
     *
     * @return NonMember
     */
    public function setTrainingDate($trainingDate)
    {
        $this->TrainingDate = $trainingDate;

        return $this;
    }

    /**
     * Get trainingDate
     *
     * @return \DateTime
     */
    public function getTrainingDate()
    {
        return $this->TrainingDate;
    }

    /**
     * Set trainingConfirmation
     *
     * @param \DateTime $trainingConfirmation
     *
     * @return NonMember
     */
    public function setTrainingConfirmation($trainingConfirmation)
    {
        $this->TrainingConfirmation = $trainingConfirmation;

        return $this;
    }

    /**
     * Get trainingConfirmation
     *
     * @return \DateTime
     */
    public function getTrainingConfirmation()
    {
        return $this->TrainingConfirmation;
    }

    /**
     * Set settlement1
     *
     * @param \DateTime $settlement1
     *
     * @return NonMember
     */
    public function setSettlement1($settlement1)
    {
        $this->Settlement1 = $settlement1;

        return $this;
    }

    /**
     * Get settlement1
     *
     * @return \DateTime
     */
    public function getSettlement1()
    {
        return $this->Settlement1;
    }

    /**
     * Set settlement2
     *
     * @param \DateTime $settlement2
     *
     * @return NonMember
     */
    public function setSettlement2($settlement2)
    {
        $this->Settlement2 = $settlement2;

        return $this;
    }

    /**
     * Get settlement2
     *
     * @return \DateTime
     */
    public function getSettlement2()
    {
        return $this->Settlement2;
    }

    /**
     * Set stresstest
     *
     * @param string $stresstest
     *
     * @return NonMember
     */
    public function setStresstest($stresstest)
    {
        $this->stresstest = $stresstest;

        return $this;
    }

    /**
     * Get stresstest
     *
     * @return string
     */
    public function getStresstest()
    {
        return $this->stresstest;
    }
}
