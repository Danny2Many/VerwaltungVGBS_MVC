<?php

namespace AppBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\PersonalData;
use Doctrine\ORM\Mapping as ORM;

class HealthData extends PersonalData {
    
      /**
     * @ORM\Column(type="text")
     */
    protected $workplaceposture;
    
    
       /**
     * @ORM\Column(type="string")
     */
    protected $chronoccupationaldis;
    
    
       /**
     * @ORM\Column(type="string")
     */
       protected $paincervicalspine;
    
        /**
     * @ORM\Column(type="string")
     */
        protected $painthoracicspine;
    
       /**
     * @ORM\Column(type="string")
     */
       protected $painlumbarspine;
    
       /**
     * @ORM\Column(type="string")
     */
       protected $upperlimbs;
    
       /**
     * @ORM\Column(type="string")
     */
       protected $lowerlimbs;
    
       /**
     * @ORM\Column(type="text")
     */
       protected $otherimpairments;
    
      /**
     * @ORM\Column(type="string")
     */
      protected $medication;
    
       /**
     * @ORM\Column(type="string")
     */
       protected $additionalagilactivities;
    
       /**
     * @ORM\Column(type="integer")
        * @Assert\Type(
     * type="numeric",
     * message="{{ value }} ist kein gültiger {{ type }}.")
     */
       protected $pulseatrest;
    
     /**
     * @ORM\Column(type="text")
     */
    protected $stresstest;
    
    
      /**
     * @ORM\Column(type="string")
     */
    protected $healthinsurance;
    
     /**
     * Set healthinsurance
     *
     * @param string $healthinsurance
     *
     * @return Member
     */
    public function setHealthinsurance($healthinsurance)
    {
        $this->healthinsurance = $healthinsurance;

        return $this;
    }

    /**
     * Get healthinsurance
     *
     * @return string
     */
    public function getHealthinsurance()
    {
        return $this->healthinsurance;
    }
    
    /**
     * Set workplaceposture
     *
     * @param string $workplaceposture
     *
     * @return Member
     */
    public function setWorkplaceposture($workplaceposture)
    {
        $this->workplaceposture = $workplaceposture;

        return $this;
    }

    /**
     * Get workplaceposture
     *
     * @return string
     */
    public function getWorkplaceposture()
    {
        return $this->workplaceposture;
    }

    /**
     * Set chronoccupationaldis
     *
     * @param string $chronoccupationaldis
     *
     * @return Member
     */
    public function setChronoccupationaldis($chronoccupationaldis)
    {
        $this->chronoccupationaldis = $chronoccupationaldis;

        return $this;
    }

    /**
     * Get chronoccupationaldis
     *
     * @return string
     */
    public function getChronoccupationaldis()
    {
        return $this->chronoccupationaldis;
    }

    /**
     * Set paincervicalspine
     *
     * @param string $paincervicalspine
     *
     * @return Member
     */
    public function setPaincervicalspine($paincervicalspine)
    {
        $this->paincervicalspine = $paincervicalspine;

        return $this;
    }

    /**
     * Get paincervicalspine
     *
     * @return string
     */
    public function getPaincervicalspine()
    {
        return $this->paincervicalspine;
    }

    /**
     * Set painthoracicspine
     *
     * @param string $painthoracicspine
     *
     * @return Member
     */
    public function setPainthoracicspine($painthoracicspine)
    {
        $this->painthoracicspine = $painthoracicspine;

        return $this;
    }

    /**
     * Get painthoracicspine
     *
     * @return string
     */
    public function getPainthoracicspine()
    {
        return $this->painthoracicspine;
    }

    /**
     * Set painlumbarspine
     *
     * @param string $painlumbarspine
     *
     * @return Member
     */
    public function setPainlumbarspine($painlumbarspine)
    {
        $this->painlumbarspine = $painlumbarspine;

        return $this;
    }

    /**
     * Get painlumbarspine
     *
     * @return string
     */
    public function getPainlumbarspine()
    {
        return $this->painlumbarspine;
    }

    /**
     * Set upperlimbs
     *
     * @param string $upperlimbs
     *
     * @return Member
     */
    public function setUpperlimbs($upperlimbs)
    {
        $this->upperlimbs = $upperlimbs;

        return $this;
    }

    /**
     * Get upperlimbs
     *
     * @return string
     */
    public function getUpperlimbs()
    {
        return $this->upperlimbs;
    }

    /**
     * Set lowerlimbs
     *
     * @param string $lowerlimbs
     *
     * @return Member
     */
    public function setLowerlimbs($lowerlimbs)
    {
        $this->lowerlimbs = $lowerlimbs;

        return $this;
    }

    /**
     * Get lowerlimbs
     *
     * @return string
     */
    public function getLowerlimbs()
    {
        return $this->lowerlimbs;
    }

    /**
     * Set otherimpairments
     *
     * @param string $otherimpairments
     *
     * @return Member
     */
    public function setOtherimpairments($otherimpairments)
    {
        $this->otherimpairments = $otherimpairments;

        return $this;
    }

    /**
     * Get otherimpairments
     *
     * @return string
     */
    public function getOtherimpairments()
    {
        return $this->otherimpairments;
    }

    /**
     * Set medication
     *
     * @param string $medication
     *
     * @return Member
     */
    public function setMedication($medication)
    {
        $this->medication = $medication;

        return $this;
    }

    /**
     * Get medication
     *
     * @return string
     */
    public function getMedication()
    {
        return $this->medication;
    }

    /**
     * Set additionalagilactivities
     *
     * @param string $additionalagilactivities
     *
     * @return Member
     */
    public function setAdditionalagilactivities($additionalagilactivities)
    {
        $this->additionalagilactivities = $additionalagilactivities;

        return $this;
    }

    /**
     * Get additionalagilactivities
     *
     * @return string
     */
    public function getAdditionalagilactivities()
    {
        return $this->additionalagilactivities;
    }

    /**
     * Set pulseatrest
     *
     * @param integer $pulseatrest
     *
     * @return Member
     */
    public function setPulseatrest($pulseatrest)
    {
        $this->pulseatrest = $pulseatrest;

        return $this;
    }

    /**
     * Get pulseatrest
     *
     * @return integer
     */
    public function getPulseatrest()
    {
        return $this->pulseatrest;
    }
}
