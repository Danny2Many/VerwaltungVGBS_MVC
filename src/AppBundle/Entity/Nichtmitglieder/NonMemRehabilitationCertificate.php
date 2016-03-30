<?php


namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemRehabilitationCertificate")
 */
class NonMemRehabilitationCertificate {
    /**
     * @ORM\ManyToOne(targetEntity="NonMember", inversedBy="rehabilitationcertificate")
     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
     */
    private $nonmember;
    
       
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $rcid;
    
     /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $nmemid;
    
     /**
      *  
      *  @ORM\Column(type="date")
      * 
       * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $terminationdate;

    /**
    *  
    *  @ORM\Column(type="integer")
    * 
    * @Assert\NotNull()
    * @Assert\Type(
    *     type="integer",
    *     message="The value {{ value }} is not a valid {{ type }}."
    * )
    */
    protected $rehabunits;

    /**
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $recorded;
    
    
    /**
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $deleted;
    
    
    
    /**
     * Get rcid
     *
     * @return integer
     */
    public function getRcid()
    {
        return $this->rcid;
    }

    /**
     * Set rcid
     *
     * @param string $rcid
     *
     * @return MemRehabilitationCertificate
     */
    public function setRcid($rcid)
    {
        $this->rcid = $rcid;

        return $this;
    }
    
    /**
     * Set nmemid
     *
     * @param integer $nmemid
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setNMemid($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
    }

    /**
     * Get nmemid
     *
     * @return integer
     */
    public function getNMemid()
    {
        return $this->nmemid;
    }

    /**
     * Set terminationdate
     *
     * @param \DateTime $terminationdate
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setTerminationdate($terminationdate)
    {
        $this->terminationdate = $terminationdate;

        return $this;
    }

    /**
     * Get terminationdate
     *
     * @return \DateTime
     */
    public function getTerminationdate()
    {
        return $this->terminationdate;
    }

    /**
     * Set nonmember
     *
     * @param \AppBundle\Entity\Nichtmitglieder\Nonmember $nonmember
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setNonmember(\AppBundle\Entity\Nichtmitglieder\Nonmember $nonmember = null)
    {
        $this->nonmember = $nonmember;

        return $this;
    }

    /**
     * Get nonmember
     *
     * @return \AppBundle\Entity\Nichtmitglieder\Nonmember
     */
    public function getNonmember()
    {
        return $this->nonmember;
        
    }
    /**
     * Set rehabunits
     *
     * @param integer $rehabunits
     *
     * @return MemRehabilitationCertificate
     */
    public function setRehabunits($rehabunits)
    {
        $this->rehabunits = $rehabunits;

        return $this;
    }

    /**
     * Get rehabunits
     *
     * @return integer
     */
    public function getRehabunits()
    {
        return $this->rehabunits;
    }

    /**
     * Set recorded
     *
     * @param string $recorded
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * Get recorded
     *
     * @return string
     */
    public function getRecorded()
    {
        return $this->recorded;
    }

    /**
     * Set deleted
     *
     * @param string $deleted
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return string
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
