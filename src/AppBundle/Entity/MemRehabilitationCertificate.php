<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="MemRehabilitationCertificate")
 * @ORM\HasLifecycleCallbacks()
 */
class MemRehabilitationCertificate {
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $rcid;
    
    
     /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $memid;
    
    
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
     * Set memid
     *
     * @param string $memid
     *
     * @return MemRehabilitationCertificate
     */
    public function setMemid($memid)
    {
        $this->memid = $memid;

        return $this;
    }

    /**
     * Get memid
     *
     * @return string
     */
    public function getMemid()
    {
        return $this->memid;
    }

    /**
     * Set terminationdate
     *
     * @param \DateTime $terminationdate
     *
     * @return MemRehabilitationCertificate
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
     * Get rcid
     *
     * @return integer
     */
    public function getRcid()
    {
        return $this->rcid;
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
 * @ORM\PrePersist
 */
    public function setRecorded()
    {
        $now= new \DateTime();
        $this->recorded = $now->format('Y-m-d');

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
     * @return MemRehabilitationCertificate
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
}
