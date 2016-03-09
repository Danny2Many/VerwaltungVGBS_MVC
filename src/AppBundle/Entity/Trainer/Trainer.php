<?php

namespace AppBundle\Entity\Trainer;

use AppBundle\Entity\PersonalData;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer")
 */

class Trainer extends PersonalData{
    
   

    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $trainerid;          
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerPhoneNumber", mappedBy="trainer", cascade={"persist"})
     */
    protected $phonenumber;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerLicence", mappedBy="trainer", cascade={"persist"})
     */
    protected $licence;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainerFocus", mappedBy="trainer", cascade={"persist"})
     */
    protected $focus;
    
    /**
     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
     * @ORM\JoinTable(name="Trainer_Section",
     *      joinColumns={@ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
     */
    protected $section;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $type;
    
    
    
   
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phonenumber = new ArrayCollection();
        $this->licence = new ArrayCollection();
        $this->focus = new ArrayCollection();
        $this->section = new ArrayCollection();
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
     * Add licence
     *
     * @param \AppBundle\Entity\Trainer\TrainerLicence $licence
     *
     * @return Trainer
     */
    public function addLicence(\AppBundle\Entity\Trainer\TrainerLicence $licence)
    {
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
     * Add focus
     *
     * @param \AppBundle\Entity\Trainer\TrainerFocus $focus
     *
     * @return Trainer
     */
    public function addFocus(\AppBundle\Entity\Trainer\TrainerFocus $focus)
    {
        $this->focus[] = $focus;

        return $this;
    }

    /**
     * Remove focus
     *
     * @param \AppBundle\Entity\Trainer\TrainerFocus $focus
     */
    public function removeFocus(\AppBundle\Entity\Trainer\TrainerFocus $focus)
    {
        $this->focus->removeElement($focus);
    }

    /**
     * Get focus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFocus()
    {
        return $this->focus;
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
    
    
//    
//    /**
//     * Add phonenumber
//     *
//     * @param \AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber
//     *
//     * @return Trainer
//     */
//    public function addPhonenumber(\AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber)
//    {               
//        $phonenumber->setTrainer($this);
//        $this->phonenumber[] = $phonenumber;
//
//        return $this;
//    }
//
//    /**
//     * Remove phonenumber
//     *
//     * @param \AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber
//     */
//    public function removePhonenumber(\AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber)
//    {
//        $this->phonenumber->removeElement($phonenumber);
//    }
//
//    /**
//     * Get phonenumber
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getPhonenumber()
//    {
//        return $this->phonenumber;
//    }
    
    
    
}
