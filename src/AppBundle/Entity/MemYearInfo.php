<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemYearInfo")
 */
class MemYearInfo {
    
    /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="yearinfo")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */
    private $member;
    
    /**
     * @ORM\ManyToOne(targetEntity="MemFinYear", inversedBy="yearinfo")
     * @ORM\JoinColumn(name="year", referencedColumnName="year")
     */
    private $finyear;
    
     /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $yiid;
    
    /**
     * 
     * @ORM\Column(type="string") 
     * 
     */
    protected $year;
    
    
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
    protected $additionalduesinfo;
    
    
    /**
     * 
     * @ORM\Column(type="float") 
     * 
     */
    protected $levy;

    

    /**
     * Set year
     *
     * @param string $year
     *
     * @return MemYearInfo
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
     * Set memid
     *
     * @param integer $memid
     *
     * @return MemYearInfo
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
     * Set additionalduesinfo
     *
     * @param string $additionalduesinfo
     *
     * @return MemYearInfo
     */
    public function setAdditionalduesinfo($additionalduesinfo)
    {
        $this->additionalduesinfo = $additionalduesinfo;

        return $this;
    }

    /**
     * Get additionalduesinfo
     *
     * @return string
     */
    public function getAdditionalduesinfo()
    {
        return $this->additionalduesinfo;
    }

    /**
     * Set levy
     *
     * @param float $levy
     *
     * @return MemYearInfo
     */
    public function setLevy($levy)
    {
        $this->levy = $levy;

        return $this;
    }

    /**
     * Get levy
     *
     * @return float
     */
    public function getLevy()
    {
        return $this->levy;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Member $member
     *
     * @return MemYearInfo
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
     * @return MemYearInfo
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
