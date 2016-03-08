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
     * Get rcid
     *
     * @return integer
     */
    public function getRcid()
    {
        return $this->rcid;
    }

    /**
     * Set memid
     *
     * @param integer $memid
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setNMemid($nmemid)
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
     * @param \AppBundle\Entity\Nichtmitglieder\NonMember $nonmember
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setNonmember(\AppBundle\Entity\Nichtmitglieder\NonMember $nonmember = null)
    {
        $this->nonmember = $nonmember;

        return $this;
    }

    /**
     * Get nonmember
     *
     * @return \AppBundle\Entity\Nichtmitglieder\NonMember
     */
    public function getNonmember()
    {
        return $this->nonmember;
    }
}
