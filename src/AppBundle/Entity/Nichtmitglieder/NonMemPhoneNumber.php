<?php



namespace AppBundle\Entity\Nichtmitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMemPhoneNumber")
 * 
 */
class NonMemPhoneNumber {
    
    /**
     * @ORM\Column(name="pnid")
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    protected $pnid;
   
    
  
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d\/\d/",
     *     message="Ihre Telefonnummer entspricht entweder nicht dem gegebenen Format oder enthält einen Buchstaben."
     * )
     */
    protected $phonenumber;
    
    
    /**
     * @ORM\Column(type="integer") 
     */
    protected $nmemid;



    /**
     * @ORM\ManyToOne(targetEntity="NonMember", inversedBy="phonenumber")
     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
     */
    protected $nonmember;




    /**
     * Get pnid
     *
     * @return string
     */
    public function getPnid()
    {
        return $this->pnid;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return NonMemPhoneNumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set nmemid
     *
     * @param integer $nmemid
     *
     * @return NonMemPhoneNumber
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
     * Set nonmember
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMember $nonmember
     *
     * @return NonMemPhoneNumber
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
