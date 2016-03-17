<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="MemFinYear")
 */
class MemFinYear {
    
    /**
     * @ORM\OneToMany(targetEntity="MemMonthlyDues", mappedBy="finyear")
     */
    private $monthlydues;
    
    /**
     * @ORM\OneToMany(targetEntity="MemYearInfo", mappedBy="finyear")
     */
    private $yearinfo;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $year;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->monthlydues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->yearinfo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    

    /**
     * Set year
     *
     * @param string $year
     *
     * @return MemFinYear
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
     * Add monthlydue
     *
     * @param \AppBundle\Entity\MmemMonthlyDues $monthlydue
     *
     * @return MemFinYear
     */
    public function addMonthlydue(\AppBundle\Entity\MemMonthlyDues $monthlydue)
    {
        $this->monthlydues[] = $monthlydue;

        return $this;
    }

    /**
     * Remove monthlydue
     *
     * @param \AppBundle\Entity\MmemMonthlyDues $monthlydue
     */
    public function removeMonthlydue(\AppBundle\Entity\MemMonthlyDues $monthlydue)
    {
        $this->monthlydues->removeElement($monthlydue);
    }

    /**
     * Get monthlydues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonthlydues()
    {
        return $this->monthlydues;
    }

    /**
     * Add yearinfo
     *
     * @param \AppBundle\Entity\MemYearInfo $yearinfo
     *
     * @return MemFinYear
     */
    public function addYearinfo(\AppBundle\Entity\MemYearInfo $yearinfo)
    {
        $this->yearinfo[] = $yearinfo;

        return $this;
    }

    /**
     * Remove yearinfo
     *
     * @param \AppBundle\Entity\MemYearInfo $yearinfo
     */
    public function removeYearinfo(\AppBundle\Entity\MemYearInfo $yearinfo)
    {
        $this->yearinfo->removeElement($yearinfo);
    }

    /**
     * Get yearinfo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getYearinfo()
    {
        return $this->yearinfo;
    }
}
