<?php



namespace AppBundle\Entity\Mitglieder;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemDuesPayed")
 */
class MemDuesPayed {
    
        /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") 
     * 
     */
    protected $dpid;
    
    
        /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Dues", inversedBy="member", cascade={"persist"})
     * @ORM\JoinColumn(name="dueid", referencedColumnName="dueid")
     */    
    protected $due;
    
    
    
        /**
     * @ORM\Column(type="integer")
        * 
     * 
     */
    protected $year;
    
        /**
     * @ORM\Column(type="integer")
        * 
     * 
     */
    protected $month;
    
    
    /**
     * @ORM\Column(type="float")
     */
    protected $duespayed;
    
    /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="duespayed")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    protected $member;

    /**
     * Get dpid
     *
     * @return integer
     */
    public function getDpid()
    {
        return $this->dpid;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return MemDuesPayed
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return MemDuesPayed
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set duespayed
     *
     * @param float $duespayed
     *
     * @return MemDuesPayed
     */
    public function setDuespayed($duespayed)
    {
        $this->duespayed = $duespayed;

        return $this;
    }

    /**
     * Get duespayed
     *
     * @return float
     */
    public function getDuespayed()
    {
        return $this->duespayed;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Mitglieder\Member $member
     *
     * @return MemDuesPayed
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

    /**
     * Set due
     *
     * @param \AppBundle\Entity\Dues $due
     *
     * @return MemDuesPayed
     */
    public function setDue(\AppBundle\Entity\Dues $due = null)
    {
        $this->due = $due;

        return $this;
    }

    /**
     * Get due
     *
     * @return \AppBundle\Entity\Dues
     */
    public function getDue()
    {
        return $this->due;
    }
}
