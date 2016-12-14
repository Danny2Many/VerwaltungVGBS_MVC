<?php

namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\PersonalData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer")
 */
class Trainer extends PersonalData {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    protected $trainerid;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $type;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerFocus", mappedBy="trainer",cascade={"persist"})
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity="TrainerLicence", mappedBy="trainer",cascade={"persist"})
     */
    private $licence;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerPhoneNumber", mappedBy="trainer",cascade={"persist"})
     */
    private $phonenumber;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $state;
    
    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Sportsgroup", inversedBy="trainersub")
     * @ORM\JoinTable(name="Trainer_SportsgroupSub", joinColumns={@ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="sgid")})
     */
    private $sportsgroupsub;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->theme = new \Doctrine\Common\Collections\ArrayCollection();
        $this->licence = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phonenumber = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sportsgroupsub = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param string $type
     *
     * @return Trainer
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Trainer
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add theme
     *
     * @param \AppBundle\Entity\Trainer\TrainerFocus $theme
     *
     * @return Trainer
     */
    public function addTheme(\AppBundle\Entity\Trainer\TrainerFocus $theme)
    {
        $theme->setTrainer($this);
        $this->theme[] = $theme;

        return $this;
    }

    /**
     * Remove theme
     *
     * @param \AppBundle\Entity\Trainer\TrainerFocus $theme
     */
    public function removeTheme(\AppBundle\Entity\Trainer\TrainerFocus $theme)
    {
        $this->theme->removeElement($theme);
    }

    /**
     * Get theme
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Add licence
     *
     * @param \AppBundle\Entity\Trainer\TrainerLicence $licence
     *
     * @return Trainer
     */
    public function addLicence(\AppBundle\Entity\Trainer\TrainerLicence $licence)
    {   
        $licence->setTrainer($this);
        $this->licence[] = $licence;

        return $this;
    }

    /**
     * Remove licence
     *
     * @param \AppBundle\Entity\Trainer\TrainerLicence $licence
     */
    public function removeLicence(\AppBundle\Entity\Trainer\TrainerLicence $licence)
    {
        $this->licence->removeElement($licence);
    }

    /**
     * Get licence
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Add phonenumber
     *
     * @param \AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber
     *
     * @return Trainer
     */
    public function addPhonenumber(\AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber)
    {   
        $phonenumber->setTrainer($this);
        $this->phonenumber[] = $phonenumber;

        return $this;
    }

    /**
     * Remove phonenumber
     *
     * @param \AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber
     */
    public function removePhonenumber(\AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber)
    {
        $this->phonenumber->removeElement($phonenumber);
    }

    /**
     * Get phonenumber
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
    
    /**
     * Add sportsgroupsub
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroupsub
     *
     * @return Sportsgroup
     */
public function addSportsgroupsub(\AppBundle\Entity\Sportsgroup $sportsgroupsub)
    {
        $sportsgroupsub->addTrainersub($this);
        $this->sportsgroupsub[] = $sportsgroupsub;

        return $this;
    }
    
   /**
     * Remove sportsgroupsub
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroupsub
     */
    public function removeSportsgroupsub(\AppBundle\Entity\Sportsgroup $sportsgroupsub)
    {
        $this->sportsgroupsub->removeElement($sportsgroupsub);
    }

    /**
     * Get sportsgroupsub
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSportsgroupsub()
    {
        return $this->sportsgroupsub;
    }  
}
