<?php

namespace AppBundle\Entity\Trainer;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerLicence")
 */
class TrainerLicence{
    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="licence")
     * @ORM\JoinColumn(name="trainerid", referencedColumnName="trainerid")
     */
    protected $trainer;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")     
     */    
    protected $trainerid;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */   
    protected $licencenumber;

     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $issuedate;
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $expirationdate;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */   
    protected $licencetype;
    
    
    
    

    /**
     * Set trainerid
     *
     * @param integer $trainerid
     *
     * @return TrainerLicence
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
     * Set licencenumber
     *
     * @param string $licencenumber
     *
     * @return TrainerLicence
     */
    public function setLicencenumber($licencenumber)
    {
        $this->licencenumber = $licencenumber;

        return $this;
    }

    /**
     * Get licencenumber
     *
     * @return string
     */
    public function getLicencenumber()
    {
        return $this->licencenumber;
    }

    /**
     * Set issuedate
     *
     * @param \DateTime $issuedate
     *
     * @return TrainerLicence
     */
    public function setIssuedate($issuedate)
    {
        $this->issuedate = $issuedate;

        return $this;
    }

    /**
     * Get issuedate
     *
     * @return \DateTime
     */
    public function getIssuedate()
    {
        return $this->issuedate;
    }

    /**
     * Set expirationdate
     *
     * @param \DateTime $expirationdate
     *
     * @return TrainerLicence
     */
    public function setExpirationdate($expirationdate)
    {
        $this->expirationdate = $expirationdate;

        return $this;
    }

    /**
     * Get expirationdate
     *
     * @return \DateTime
     */
    public function getExpirationdate()
    {
        return $this->expirationdate;
    }

    /**
     * Set licencetype
     *
     * @param string $licencetype
     *
     * @return TrainerLicence
     */
    public function setLicencetype($licencetype)
    {
        $this->licencetype = $licencetype;

        return $this;
    }

    /**
     * Get licencetype
     *
     * @return string
     */
    public function getLicencetype()
    {
        return $this->licencetype;
    }

    /**
     * Set trainer
     *
     * @param \AppBundle\Entity\Trainer\Trainer $trainer
     *
     * @return TrainerLicence
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
