<?php

namespace AppBundle\Entity\Trainer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TrainerLicence")
 * @ORM\HasLifecycleCallbacks()
 */
class TrainerLicence {
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $liid;
    
    /**
     * @ORM\Column(type="string") 
     */
    protected $trainerid;
    
    /**
     * @ORM\Column(type="string") 
     */
    protected $licencetype;
    
    /**
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
    
//    /**
//     * @ORM\Column(type="date")
//     */
//    protected $deleted;
//    
//    /**
//     * @ORM\Column(type="string")
//     */
//    protected $recorded;

    /**
     * Get liid
     *
     * @return integer
     */
    public function getLiid()
    {
        return $this->liid;
    }

    /**
     * Set trainerid
     *
     * @param string $trainerid
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
     * @return string
     */
    public function getTrainerid()
    {
        return $this->trainerid;
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

    /**
     * Set liid
     *
     * @param integer $liid
     *
     * @return TrainerLicence
     */
    public function setLiid($liid)
    {
        $this->liid = $liid;

        return $this;
    }

//    /**
//     * Set deleted
//     *
//     * @param \DateTime $deleted
//     *
//     * @return TrainerLicence
//     */
//    public function setDeleted($deleted)
//    {
//        $this->deleted = $deleted;
//
//        return $this;
//    }
//
//    /**
//     * Get deleted
//     *
//     * @return \DateTime
//     */
//    public function getDeleted()
//    {
//        return $this->deleted;
//    }
//
//    /**
//     * @ORM\PrePersist
//     */
//    public function setRecorded()
//    {
//        $now= new \DateTime();
//        $this->recorded = $now->format('Y-m-d');
//
//        return $this;
//    }
//
//    /**
//     * Get recorded
//     *
//     * @return \DateTime
//     */
//    public function getRecorded()
//    {
//        return $this->recorded;
//    }
}
