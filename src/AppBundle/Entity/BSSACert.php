<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="BSSACert")
 * @ORM\HasLifecycleCallbacks()
 */
class BSSACert {
 /**
* @ORM\Id
* @ORM\Column(name="bssaid", type="integer")
* @ORM\OneToOne(targetEntity="NonMemSportsgroup", mappedBy="BSSACert")
*/
protected $bssaid;

/**
* @ORM\Column(type="date")  
*/ 
protected $terminationdate;

/**
* @ORM\Column(type="date")  
*/ 
protected $startdate;
/**
* @ORM\Column(type="string")  
*/ 
protected $groupnr;

/**
* @ORM\Column(type="string")  
*/ 
protected $bssacertnr;

/**
* @ORM\Id
* @ORM\Column(type="string")  
*/
protected $recorded;

/**
* @ORM\Column(type="date")
*/
protected $deleted;




    
 

    /**
     * Set bssaid
     *
     * @param integer $bssaid
     *
     * @return BSSACert
     */
    public function setBssaid($bssaid)
    {
        $this->bssaid = $bssaid;

        return $this;
    }

    /**
     * Get bssaid
     *
     * @return integer
     */
    public function getBssaid()
    {
        return $this->bssaid;
    }

    /**
     * Set terminationdate
     *
     * @param \DateTime $terminationdate
     *
     * @return BSSACert
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
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return BSSACert
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set groupnr
     *
     * @param string $groupnr
     *
     * @return BSSACert
     */
    public function setGroupnr($groupnr)
    {
        $this->groupnr = $groupnr;

        return $this;
    }

    /**
     * Get groupnr
     *
     * @return string
     */
    public function getGroupnr()
    {
        return $this->groupnr;
    }

    /**
     * Set bssacertnr
     *
     * @param string $bssacertnr
     *
     * @return BSSACert
     */
    public function setBssacertnr($bssacertnr)
    {
        $this->bssacertnr = $bssacertnr;

        return $this;
    }

    /**
     * Get bssacertnr
     *
     * @return string
     */
    public function getBssacertnr()
    {
        return $this->bssacertnr;
    }

    /**
     * Set recorded
     *
     * @param string $recorded
     *
     * @return BSSACert
     */
    public function setRecorded($recorded)
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * Get recorded
     *
     * @return string
     */
    public function getRecorded()
    {
        return $this->recorded;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return BSSACert
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
