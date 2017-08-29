<?php

namespace AppBundle\Entity\Mitglieder_NichtMitglieder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonAndMemPeriodOfRest")
 * 
 */
class NonAndMemPeriodOfRest {


 
    
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")  
    */
    protected $prid;  
    

    /**
     * @ORM\ManyToOne(targetEntity="Member_Sportsgroup", inversedBy="periodOfRest")
     * @ORM\JoinColumn(name="memsgid", referencedColumnName="memsgid")
     */
    private $memberSportsgroupAssignment;



    /**
    *
    * @ORM\Column(type="date")
    */
    protected $restingbegin;



    /**
    * @ORM\Column(type="date")
    */
    protected $restingend;
        


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload=null)
    {
        $restingEnd = $this->getRestingend();
        if($restingEnd != null)
        {
            if(strtotime($this->getRestingbegin()->format('Y-m-d')) >= strtotime($restingEnd->format('Y-m-d')))
            {
                $context->buildViolation('Das Ende der Ruhephase muss jünger sein, als der Beginn.')
                        ->atPath('restingend')
                        ->addViolation();
            }
        }
    }
    


    /**
     * Get prid
     *
     * @return integer
     */
    public function getPrid()
    {
        return $this->prid;
    }

    /**
     * Set restingbegin
     *
     * @param \DateTime $restingbegin
     *
     * @return NonAndMemPeriodOfRest
     */
    public function setRestingbegin($restingbegin)
    {
        $this->restingbegin = $restingbegin;

        return $this;
    }

    /**
     * Get restingbegin
     *
     * @return \DateTime
     */
    public function getRestingbegin()
    {
        return $this->restingbegin;
    }

    /**
     * Set restingend
     *
     * @param \DateTime $restingend
     *
     * @return NonAndMemPeriodOfRest
     */
    public function setRestingend($restingend)
    {
        $this->restingend = $restingend;

        return $this;
    }

    /**
     * Get restingend
     *
     * @return \DateTime
     */
    public function getRestingend()
    {
        return $this->restingend;
    }



    /**
     * Set memberSportsgroupAssignment
     *
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memberSportsgroupAssignment
     *
     * @return NonAndMemPeriodOfRest
     */
    public function setMemberSportsgroupAssignment(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup $memberSportsgroupAssignment = null)
    {
        $this->memberSportsgroupAssignment = $memberSportsgroupAssignment;

        return $this;
    }

    /**
     * Get memberSportsgroupAssignment
     *
     * @return \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Sportsgroup
     */
    public function getMemberSportsgroupAssignment()
    {
        return $this->memberSportsgroupAssignment;
    }
}
