<?php



namespace AppBundle\Entity\Nichtmitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemRehabilitationCertificate")
 * 
 */
class NonMemRehabilitationCertificate {
    
    
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
    protected $nmemid;

        /**
     * @ORM\ManyToOne(targetEntity="NonMember", inversedBy="rehabilitationcertificate")
     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
     */
    protected $nonmember;

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
     * Get rcid
     *
     * @return string
     */
    public function getRcid()
    {
        return $this->rcid;
    }

    /**
     * Set nmemid
     *
     * @param integer $nmemid
     *
     * @return NonMemRehabilitationCertificate
     */
    public function setNmemid($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
    }

    /**
     * Get nmemid
     *
     * @return integer
     */
    public function getNmemid()
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
     * Set rehabunits
     *
     * @param integer $rehabunits
     *
     * @return NonMemRehabilitationCertificate
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
