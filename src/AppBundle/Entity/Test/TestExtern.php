<?php


namespace AppBundle\Entity\Test;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestExtern")
 * 
 */
class TestExtern {
    
    /**
     * @ORM\ManyToMany(targetEntity="TestExternSG")
     * @ORM\JoinTable(name="TestExtern_SG",
     *      joinColumns={@ORM\JoinColumn(name="teid", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sgid", referencedColumnName="id")}
     *      )
     */
    protected $testexternsg;
    
    
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
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     */
    protected $firstname;

     /**
     * @ORM\Column(type="string")
     */
    
    protected $lastname;
    
    
    
     /**
     * @ORM\Column(type="string")
      * @Assert\NotBlank()
     * 
     */
    protected $title;
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $birthday;
    
     /**
     * @ORM\Column(type="string")
      * @Assert\NotBlank()
     * 
     */
    protected $streetaddress;
    
     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * 
     */
    protected $postcode;
    
     
    
     /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     */
    protected $location;
    

    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    
    function getFirstname() {
        return $this->firstname;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getTitle() {
        return $this->title;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getStreetaddress() {
        return $this->streetaddress;
    }

    function getPostcode() {
        return $this->postcode;
    }

    function getLocation() {
        return $this->location;
    }

    function getEmail() {
        return $this->email;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setStreetaddress($streetaddress) {
        $this->streetaddress = $streetaddress;
    }

    function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setEmail($email) {
        $this->email = $email;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testexternsg = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add testexternsg
     *
     * @param \AppBundle\Entity\TestExternSG $testexternsg
     *
     * @return TestExtern
     */
    public function addTestexternsg(\AppBundle\Entity\TestExternSG $testexternsg)
    {
        $this->testexternsg[] = $testexternsg;

        return $this;
    }

    /**
     * Remove testexternsg
     *
     * @param \AppBundle\Entity\TestExternSG $testexternsg
     */
    public function removeTestexternsg(\AppBundle\Entity\TestExternSG $testexternsg)
    {
        $this->testexternsg->removeElement($testexternsg);
    }

    /**
     * Get testexternsg
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestexternsg()
    {
        return $this->testexternsg;
    }
}
