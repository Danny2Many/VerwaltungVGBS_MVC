<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember_Sportsgroup")
 * @ORM\HasLifecycleCallbacks()
 */
class NonMember_Sportsgroup {

public function __toString(){
//    return (string) $this->nmemid.'id/'.$this->sgid.'/Nichtmitglieder\NonMember_Sportsgroup';
    return (string) 'a/a/Nichtmitglieder\NonMember_Sportsgroup';

   
}
    
/**
* @ORM\Id
* @ORM\Column(type="integer")  
*/
protected $sgid;
/**
* @ORM\Id
* @ORM\Column(type="integer")  
*/ 
protected $nmemid;
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
     * Set sgid
     *
     * @param integer $sgid
     *
     * @return NonMember_Sportsgroup
     */
    public function setSgid($sgid)
    {
        $this->sgid = $sgid;

        return $this;
    }

    /**
     * Get sgid
     *
     * @return integer
     */
    public function getSgid()
    {
        return $this->sgid;
    }

    /**
     * Set nmemid
     *
     * @param integer $nmemid
     *
     * @return NonMember_Sportsgroup
     */
    public function setNmemid($nmemid)
    {
        $this->nmemid = $nmemid;

        return $this;
    }

    /**
     * Get nmemid
     *
     * @return integer
     */
    public function getNmemid()
    {
        return $this->nmemid;
    }
    
  
    /**
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return NonMember_Sportsgroup
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
     * @return NonMember_Sportsgroup
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
