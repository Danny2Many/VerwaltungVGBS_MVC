<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="MemPhoneNumber")
 * 
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
     * @ORM\Id
     * @ORM\Column(type="string")
     * 
     */
    protected $validfrom;
    
    
    /**
     * 
     * @ORM\Column(type="string")
     * 
     */
    protected $validto;
    
    
     public function __toString()
    {
        return (string) $this->pnid.'/pn/MemPhoneNumber';
    }

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

    /**
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return MemPhoneNumber
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
     * @return MemPhoneNumber
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
}
