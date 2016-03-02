<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemPhoneNumber")
 */
class MemPhoneNumber {
    
  /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="phonenumber", cascade={"persist"})
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    private $member;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $phid;
    
    /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $memid;   
    
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
     * Get phid
     *
     * @return integer
     */
    public function getPhid()
    {
        return $this->phid;
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
     * Set member
     *
     * @param \AppBundle\Entity\Member $member
     *
     * @return MemPhoneNumber
     */
    public function setMember(\AppBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
