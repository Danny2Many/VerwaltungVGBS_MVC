<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity
 * @ORM\Table(name="MemMonthlyDues")
 */
class MemMonthlyDues {
    /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="monthlydues")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    private $member;
    
    /**
     * @ORM\ManyToOne(targetEntity="MemFinYear", inversedBy="monthlydues")
     * @ORM\JoinColumn(name="year", referencedColumnName="year")
     */
    private $finyear;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $mdid;
    
    /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $memid;
    
     /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $year;
    
     /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $month;
    
    
    /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $dues;
    
    /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $duespayed;

    

    /**
     * Set memid
     *
     * @param integer $memid
     *
     * @return MemMonthlyDues
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
     * Set year
     *
     * @param string $year
     *
     * @return MemMonthlyDues
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param string $month
     *
     * @return MemMonthlyDues
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set dues
     *
     * @param string $dues
     *
     * @return MemMonthlyDues
     */
    public function setDues($dues)
    {
        $this->dues = $dues;

        return $this;
    }

    /**
     * Get dues
     *
     * @return string
     */
    public function getDues()
    {
        return $this->dues;
    }

    /**
     * Set duespayed
     *
     * @param string $duespayed
     *
     * @return MemMonthlyDues
     */
    public function setDuespayed($duespayed)
    {
        $this->duespayed = $duespayed;

        return $this;
    }

    /**
     * Get duespayed
     *
     * @return string
     */
    public function getDuespayed()
    {
        return $this->duespayed;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Member $member
     *
     * @return MemMonthlyDues
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

    /**
     * Set finyear
     *
     * @param \AppBundle\Entity\MemFinYear $finyear
     *
     * @return MemMonthlyDues
     */
    public function setFinyear(\AppBundle\Entity\MemFinYear $finyear = null)
    {
        $this->finyear = $finyear;

        return $this;
    }

    /**
     * Get finyear
     *
     * @return \AppBundle\Entity\MemFinYear
     */
    public function getFinyear()
    {
        return $this->finyear;
    }
}
