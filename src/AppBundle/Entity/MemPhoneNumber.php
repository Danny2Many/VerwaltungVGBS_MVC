<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemPhoneNumber")
 * @ORM\HasLifecycleCallbacks()
 */
class MemPhoneNumber {
    
  
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $pnid;
   
    
    /**
     * 
     * @ORM\Column(type="string") 
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
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $recorded;
    
    
    /**
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $deleted;
    

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
     * @param string $memid
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
     * @return string
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
 * @ORM\PrePersist
 */
    public function setRecorded()
    {
        $now= new \DateTime();
        
        $this->recorded = $now->format('Y-m-d');

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
     * @param string $deleted
     *
     * @return MemPhoneNumber
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return string
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

   

    /**
     * Set pnid
     *
     * @param string $pnid
     *
     * @return MemPhoneNumber
     */
    public function setPnid($pnid)
    {
        $this->pnid = $pnid;

        return $this;
    }

    /**
     * Get pnid
     *
     * @return string
     */
    public function getPnid()
    {
        return $this->pnid;
    }
}
