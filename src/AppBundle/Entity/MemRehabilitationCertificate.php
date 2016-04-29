<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="MemRehabilitationCertificate")
 * 
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
     * @ORM\Id
     * @ORM\Column(type="string")
     * 
     */
    protected $validfrom;
    
    
    /**
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $validto;
    
    
    
    
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

    
    
    
    public function __toString()
    {
        return (string) $this->rcid.'/rc/MemRehabilitationCertificate';
    }
    
    
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
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return MemRehabilitationCertificate
     */
    public function setValidfrom($validfrom)
    {
        $this->validfrom = $validfrom;

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
     * @return MemRehabilitationCertificate
     */
    public function setValidto($validto)
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
