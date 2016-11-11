<?php

namespace AppBundle\Entity\Nichtmitglieder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonMember_Sportsgroup")
 * 
 */
class NonMember_Sportsgroup {


 
    
  /**
* @ORM\Id
* @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")  
*/
protected $nmemsgid;  
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Sportsgroup", inversedBy="nonmemsubscriber", cascade={"persist"})
     * @ORM\JoinColumn(name="sgid", referencedColumnName="sgid")
     */    
    protected $sportsgroup;

    
        /**
     * @ORM\ManyToOne(targetEntity="NonMember", inversedBy="sportsgroup")
     * @ORM\JoinColumn(name="nmemid", referencedColumnName="nmemid")
     */ 
    protected $nonmember;



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
     * Get nmemsgid
     *
     * @return integer
     */
    public function getNmemsgid()
    {
        return $this->nmemsgid;
    }

    /**
     * Set joined
     *
     * @param \DateTime $joined
     *
     * @return NonMember_Sportsgroup
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
     * @return NonMember_Sportsgroup
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
     * @return NonMember_Sportsgroup
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
     * Set nonmember
     *
     * @param \AppBundle\Entity\Nichtmitglieder\NonMember $nonmember
     *
     * @return NonMember_Sportsgroup
     */
    public function setNonmember(\AppBundle\Entity\Nichtmitglieder\NonMember $nonmember = null)
    {
        $this->nonmember = $nonmember;

        return $this;
    }

    /**
     * Get nonmember
     *
     * @return \AppBundle\Entity\Nichtmitglieder\NonMember
     */
    public function getNonmember()
    {
        return $this->nonmember;
    }
}
