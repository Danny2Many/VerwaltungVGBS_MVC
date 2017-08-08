<?php


namespace AppBundle\Entity\Beitraege;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="Dues")
 * 
 */
class Dues {
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->member = new ArrayCollection();
        $this->duescharge = new ArrayCollection();
    }
    
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") 
     * 
     */
    protected $dueid;
    

    
   /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(max=150, maxMessage="Dieser Name ist zu lang. Er darf Maximal {{ limit }} Zeichen lang sein.")
     */
    protected $name;
    
    
     /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues", mappedBy="due")
     */
    protected $member;
    
    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Beitraege\DuesPrice", mappedBy="due",cascade={"persist"})
     * @ORM\OrderBy({"validfrom" = "DESC"})
     * 
     */
    protected $duescharge;
    
    
    
  /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Length(max=500, maxMessage="Diese Beschreibung ist zu lang. Sie darf Maximal {{ limit }} Zeichen lang sein.") 
     */
    protected $description;
    
  /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    protected $type;
    
      /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    protected $state;

    /**
     * Get dueid
     *
     * @return integer
     */
    public function getDueid()
    {
        return $this->dueid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Dues
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    


    /**
     * Add member
     *
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues $member
     *
     * @return Dues
     */
    public function addMember(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues $member)
    {
        $this->member[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues $member
     */
    public function removeMember(\AppBundle\Entity\Mitglieder_NichtMitglieder\Member_Dues $member)
    {
        $this->member->removeElement($member);
    }

    /**
     * Get member
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMember()
    {
        return $this->member;
    }


   


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Dues
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    

    /**
     * Add duescharge
     *
     * @param \AppBundle\Entity\Beitraege\DuesPrice $duescharge
     *
     * @return Dues
     */
    public function addDuescharge(\AppBundle\Entity\Beitraege\DuesPrice $duescharge)
    {
        $duescharge->setDue($this);
        $this->duescharge[] = $duescharge;

        return $this;
    }

    /**
     * Remove duescharge
     *
     * @param \AppBundle\Entity\Beitraege\DuesPrice $duescharge
     */
    public function removeDuescharge(\AppBundle\Entity\Beitraege\DuesPrice $duescharge)
    {
        $this->duescharge->removeElement($duescharge);
    }

    /**
     * Get duescharge
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDuescharge()
    {
        return $this->duescharge;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Dues
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Dues
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * @Assert\Callback
     */
    public function validateValidFromDates(ExecutionContextInterface $context)
    {
         $checkArray= $this->getDuescharge()->toArray();

            while(count($checkArray)>=2){
                $checkCharge=array_pop($checkArray);
               
                foreach ($checkArray as $dc){
                    if($dc->getValidfrom()->format('m.Y')==$checkCharge->getValidfrom()->format('m.Y')){
                        $context->buildViolation('Ein Beitrag darf keine zwei Preise besitzen, die ab dem selben Monat des selben Jahres gültig sind.')
                                ->atPath('duescharge_0')
                                
                                ->addViolation();
                    }
                }
            }
    }
}
