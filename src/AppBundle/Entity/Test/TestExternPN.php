<?php


namespace AppBundle\Entity\Test;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestExternPN")
 * 
 */
class TestExternPN {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string") 
     * 
     */
    protected $id;
    
    function setId($id) {
        $this->id = $id;
    }

        /**
     * @ORM\ManyToOne(targetEntity="TestExtern")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id")
     */
    protected $testextern;
    
    /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     */
    protected $phonenumber;

     



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return TestExternPN
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
     * Set testextern
     *
     * @param \AppBundle\Entity\TestExtern $testextern
     *
     * @return TestExternPN
     */
    public function setTestextern(\AppBundle\Entity\TestExtern $testextern = null)
    {
        $this->testextern = $testextern;

        return $this;
    }

    /**
     * Get testextern
     *
     * @return \AppBundle\Entity\TestExtern
     */
    public function getTestextern()
    {
        return $this->testextern;
    }
}
