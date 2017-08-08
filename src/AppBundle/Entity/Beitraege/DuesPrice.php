<?php


namespace AppBundle\Entity\Beitraege;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="DuesPrice")
 * 
 */
class DuesPrice {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") 
     * 
     */
    protected $dpid;
    
        /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Beitraege\Dues", inversedBy="duescharge", cascade={"persist"})
     * @ORM\JoinColumn(name="dueid", referencedColumnName="dueid")
     */    
    protected $due;
    
    
       /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * 
     */
    protected $price;
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * 
     */
    protected $validfrom;
    
    

    /**
     * Get dpid
     *
     * @return integer
     */
    public function getDpid()
    {
        return $this->dpid;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set validfrom
     *
     * @param \DateTime $validfrom
     *
     * @return Price
     */
    public function setValidfrom($validfrom)
    {
        $this->validfrom = $validfrom;

        return $this;
    }

    /**
     * Get validfrom
     *
     * @return \DateTime
     */
    public function getValidfrom()
    {
        return $this->validfrom;
    }

    

    /**
     * Set due
     *
     * @param \AppBundle\Entity\Beitraege\Dues $due
     *
     * @return Price
     */
    public function setDue(\AppBundle\Entity\Beitraege\Dues $due = null)
    {
        $this->due = $due;

        return $this;
    }

    /**
     * Get due
     *
     * @return \AppBundle\Entity\Beitraege\Dues
     */
    public function getDue()
    {
        return $this->due;
    }
}
