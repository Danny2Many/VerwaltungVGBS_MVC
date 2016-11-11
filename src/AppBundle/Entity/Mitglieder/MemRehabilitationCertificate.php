<?php



namespace AppBundle\Entity\Mitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="MemRehabilitationCertificate")
 * 
 */
class MemRehabilitationCertificate {
    
    
    /**
     * @ORM\Column(name="rcid")
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $rcid;
    
    
        /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    protected $memid;

        /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="rehabilitationcertificate")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    private $member;

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

    
    
    
//    public function __toString()
//    {
//        return (string) $this->rcid.'/rc/MemRehabilitationCertificate';
//    }
//    
    
    /**


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
     * Set memid
     *
     * @param integer $memid
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
     * @return integer
     */
    public function getMemid()
    {
        return $this->memid;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Mitglieder\Member $member
     *
     * @return MemRehabilitationCertificate
     */
    public function setMember(\AppBundle\Entity\Mitglieder\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\Mitglieder\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
