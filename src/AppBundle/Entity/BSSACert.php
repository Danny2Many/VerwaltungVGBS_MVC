<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="BSSACert")
 * @ORM\HasLifecycleCallbacks()
 */
class BSSACert {
    
 /**
* @ORM\Id
* @ORM\Column(name="bssaid")
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
protected $validfrom;

/**
* @ORM\Column(type="string")
*/
protected $validto;


/**
* @ORM\Column(type="string")
*/
protected $sgid;


public function __toString()
    {
        return (string) $this->sgid.'/sg/BSSACertificate';
    }

    
 

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

    /**
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return BSSACert
     */
    public function setValidfrom($validfrom)
    {
        $this->validfrom = $validfrom;

        return $this;
    }

    /**
     * Get validfrom
     *
     * @return string
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }

    /**
     * Set validto
     *
     * @param string $validto
     *
     * @return BSSACert
     */
    public function setValidto($validto)
    {
        $this->validto = $validto;

        return $this;
    }

    /**
     * Get validto
     *
     * @return string
     */
    public function getValidto()
    {
        return $this->validto;
    }

    /**
     * Set sgid
     *
     * @param string $sgid
     *
     * @return BSSACert
     */
    public function setSgid($sgid)
    {
        $this->sgid = $sgid;

        return $this;
    }

    /**
     * Get sgid
     *
     * @return string
     */
    public function getSgid()
    {
        return $this->sgid;
    }
}
