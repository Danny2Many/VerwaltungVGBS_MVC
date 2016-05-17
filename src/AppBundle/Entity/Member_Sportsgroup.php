<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Member_Sportsgroup")
 * @ORM\HasLifecycleCallbacks()
 */
class Member_Sportsgroup {

public function __toString(){
//    return (string) $this->nmemid.'id/'.$this->sgid.'/Nichtmitglieder\NonMember_Sportsgroup';
    return (string) 'a/a/Member_Sportsgroup';

   
}
    
/**
* @ORM\Id
* @ORM\Column(type="string")  
*/
protected $sgid;
/**
* @ORM\Id
* @ORM\Column(type="integer")  
*/ 
protected $memid;
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
     * @param string $sgid
     *
     * @return Member_Sportsgroup
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

    /**
     * Set memid
     *
     * @param integer $memid
     *
     * @return Member_Sportsgroup
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
     * Set validfrom
     *
     * @param string $validfrom
     *
     * @return Member_Sportsgroup
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
     * @return Member_Sportsgroup
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
