<?php

namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\PersonalData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Trainer")
 * @ORM\HasLifecycleCallbacks()
 */
class Trainer extends PersonalData {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    
    protected $trainerid;
    
    public function __toString()
    {
        return (string) $this->trainerid;
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $validfrom;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $type;
//    /**
//     * @ORM\ManyToMany(targetEntity="\AppBundle\Entity\Section")
//     * @ORM\JoinTable(name="Trainer_Section",
//     * joinColumns={@ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")},
//     * inverseJoinColumns={@ORM\JoinColumn(name="secid", referencedColumnName="secid")})
//     */
//    protected $section;
    
  
    protected $theme;


    protected $licence;
    
    
    protected $phonenumber;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $state;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $validto;
    
    




    /** @ORM\PostLoad */
    public function __construct()
    {
//        $this->section = new \Doctrine\Common\Collections\ArrayCollection();
        $this->licence = new ArrayCollection();
        $this->phonenumber = new ArrayCollection();
        $this->theme = new ArrayCollection();
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
//
//    /**
//     * Add section
//     *
//     * @param \AppBundle\Entity\Section $section
//     *
//     * @return Trainer
//     */
//    public function addSection(\AppBundle\Entity\Section $section)
//    {
//        $this->section[] = $section;
//
//        return $this;
//    }
//
//    /**
//     * Remove section
//     *
//     * @param \AppBundle\Entity\Section $section
//     */
//    public function removeSection(\AppBundle\Entity\Section $section)
//    {
//        $this->section->removeElement($section);
//    }
//
//    /**
//     * Get section
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getSection()
//    {
//        return $this->section;
//    }

    

    
    public function addLicence(\AppBundle\Entity\Trainer\TrainerLicence $licence)
    {
        $licence->setTrainerid($this);

        $this->licence->add($licence);

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

    
    public function addTheme(\AppBundle\Entity\Trainer\TrainerFocus $theme)
    {
        $theme->setTrainerid($this);

        $this->theme->add($theme);

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
     

   
    public function addPhonenumber(\AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber)
    {               
        $phonenumber->setTrainerid($this);
        
        $this->phonenumber->add($phonenumber);

        return $this;
    }

    /**
     * Remove phonenumber
     *
     * @param \AppBundle\Entity\Trainer\TrainerPhoneNumber $phonenumber
    */
    public function removePhonenumber($phonenumber)
    {
        $this->phonenumber->removeElement($phonenumber);
        
        return $this;
    }

    /**
     * Set state
     *
     * @param string $state
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
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set trainerid
     *
     * @param string $trainerid
     *
     * @return Trainer
     */
    public function setTrainerid($trainerid)
    {
        $this->trainerid = $trainerid;

        return $this;
    }

   /**
    * @ORM\PrePersist
    */
    public function setValidfrom()
    {
        $now= new \DateTime();
        $this->validfrom = $now->format('Y');

        return $this;
    }

    /**
     * Get validfrom
     *
     * @return string
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }

    /**
     * Set validto
     *
     * @param string $validto
     *
     * @return Trainer
     */
    public function setValidto( $validto)
    {
        $this->validto = $validto;

        return $this;
    }

    /**
     * Get validto
     *
     * @return string
     */
    public function getValidto()
    {
        return $this->validto;
    }
}
