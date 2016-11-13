<?php



namespace AppBundle\Entity\Mitglieder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Member_Dues")
 * 
 */
class Member_Dues {
      /**
* @ORM\Id
* @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")  
*/
protected $mdid;  
    
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Dues", inversedBy="member", cascade={"persist"})
     * @ORM\JoinColumn(name="dueid", referencedColumnName="dueid")
     */    
    protected $due;

    
        /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="due")
     * @ORM\JoinColumn(name="memid", referencedColumnName="memid")
     */ 
    protected $member;
    
    
    
    /**
*
* @ORM\Column(type="date")
*/
protected $paystart;



/**
* @ORM\Column(type="date")
*/
protected $payend;




    /**
     * Get mdid
     *
     * @return integer
     */
    public function getMdid()
    {
        return $this->mdid;
    }

    /**
     * Set paystart
     *
     * @param \DateTime $paystart
     *
     * @return Member_Dues
     */
    public function setPaystart($paystart)
    {
        $this->paystart = $paystart;

        return $this;
    }

    /**
     * Get paystart
     *
     * @return \DateTime
     */
    public function getPaystart()
    {
        return $this->paystart;
    }

    /**
     * Set payend
     *
     * @param \DateTime $payend
     *
     * @return Member_Dues
     */
    public function setPayend($payend)
    {
        $this->payend = $payend;

        return $this;
    }

    /**
     * Get payend
     *
     * @return \DateTime
     */
    public function getPayend()
    {
        return $this->payend;
    }

    /**
     * Set due
     *
     * @param \AppBundle\Entity\Due $due
     *
     * @return Member_Dues
     */
    public function setDue(\AppBundle\Entity\Due $due = null)
    {
        $this->due = $due;

        return $this;
    }

    /**
     * Get due
     *
     * @return \AppBundle\Entity\Due
     */
    public function getDue()
    {
        return $this->due;
    }

    /**
     * Set member
     *
     * @param \AppBundle\Entity\Mitglieder\Member $member
     *
     * @return Member_Dues
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
