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
     * @ORM\Column(type="string")
     */
    protected $type;
    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
     * @ORM\JoinTable(name="Trainer_Section",
     * joinColumns={@ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")},
     * inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
     */
    protected $section;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerFocus", mappedBy="trainer", cascade={"all"})
     */
    protected $theme;


    /**
     * @ORM\OneToMany(targetEntity="TrainerLicence", mappedBy="trainer", cascade={"all"})
     */  
    protected $licence;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerPhoneNumber", mappedBy="trainer", cascade={"all"})
     */ 
    protected $phonenumber;
    
    
    

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
        $this->licence = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phonenumber = new \Doctrine\Common\Collections\ArrayCollection();
        $this->theme = new \Doctrine\Common\Collections\ArrayCollection();

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
     * Add section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Trainer
     */
    public function addSection(\AppBundle\Entity\Section $section)
    {
        $this->section[] = $section;

        return $this;
    }

    /**
     * Remove section
     *
     * @param \AppBundle\Entity\Section $section
     */
    public function removeSection(\AppBundle\Entity\Section $section)
    {
        $this->section->removeElement($section);
    }

    /**
     * Get section
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSection()
    {
        return $this->section;
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
     * Set licence
     *
     * @param string $licence
     *
     * @return TrainerLicence
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
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
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return TrainerPhoneNumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
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
}
