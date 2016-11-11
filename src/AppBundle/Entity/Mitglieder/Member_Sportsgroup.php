<?php

namespace AppBundle\Entity\Mitglieder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Member_Sportsgroup")
 * 
 */
class Member_Sportsgroup {


 
    
  /**
* @ORM\Id
* @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")  
*/
protected $memsgid;  
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Sportsgroup", inversedBy="memsubscriber", cascade={"persist"})
     * @ORM\JoinColumn(name="sgid", referencedColumnName="sgid")
     */    
    protected $sportsgroup;

    
        /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="sportsgroup")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */ 
    protected $member;



/**
*
* @ORM\Column(type="date")
*/
protected $joined;



/**
* @ORM\Column(type="date")
*/
protected $resignedfrom;
        


    /**
     * Get memsgid
     *
     * @return integer
     */
    public function getMemsgid()
    {
        return $this->memsgid;
    }

    /**
     * Set joined
     *
     * @param \DateTime $joined
     *
     * @return Member_Sportsgroup
     */
    public function setJoined($joined)
    {
        $this->joined = $joined;

        return $this;
    }

    /**
     * Get joined
     *
     * @return \DateTime
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * Set resignedfrom
     *
     * @param \DateTime $resignedfrom
     *
     * @return Member_Sportsgroup
     */
    public function setResignedfrom($resignedfrom)
    {
        $this->resignedfrom = $resignedfrom;

        return $this;
    }

    /**
     * Get resignedfrom
     *
     * @return \DateTime
     */
    public function getResignedfrom()
    {
        return $this->resignedfrom;
    }

    /**
     * Set sportsgroup
     *
     * @param \AppBundle\Entity\Sportsgroup $sportsgroup
     *
     * @return Member_Sportsgroup
     */
    public function setSportsgroup(\AppBundle\Entity\Sportsgroup $sportsgroup = null)
    {
        $this->sportsgroup = $sportsgroup;

        return $this;
    }

    /**
     * Get sportsgroup
     *
     * @return \AppBundle\Entity\Sportsgroup
     */
    public function getSportsgroup()
    {
        return $this->sportsgroup;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Mitglieder\Member $member
     *
     * @return Member_Sportsgroup
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
}
