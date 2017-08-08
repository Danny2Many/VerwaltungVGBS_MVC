<?php



namespace AppBundle\Entity\Mitglieder_NichtMitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonAndMemPhoneNumber")
 * 
 */
class MemPhoneNumber {
    
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
     *     message="Ihre Telefonnummer entspricht entweder nicht dem gegebenen Format (Vorwahl/Telephonnummer) oder enthält einen Buchstaben."
     * )
     */
    protected $phonenumber;
    
    
    /**
     * @ORM\Column(type="integer") 
     */
    protected $memid;



    /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="phonenumber")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    private $member;





    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return MemPhoneNumber
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
     * Get pnid
     *
     * @return integer
     */
    public function getPnid()
    {
        return $this->pnid;
    }

    /**
     * Set memid
     *
     * @param integer $memid
     *
     * @return MemPhoneNumber
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
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member $member
     *
     * @return MemPhoneNumber
     */
    public function setMember(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\Mitglieder_NichtMitglieder\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
