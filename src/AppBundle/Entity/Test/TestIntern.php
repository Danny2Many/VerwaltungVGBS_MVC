<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestIntern")
 * 
 */
class TestIntern {
    
    
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     */
    protected $id;
    
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
     * @ORM\Column(type="string")
     */
    protected $recordedat;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $deletedat;
    
    
    function getValidfrom() {
        return $this->validfrom;
    }

    function getValidto() {
        return $this->validto;
    }

    function getRecordedat() {
        return $this->recordedat;
    }

    function getDeletedat() {
        return $this->deletedat;
    }

    function setValidfrom($validfrom) {
        $this->validfrom = $validfrom;
    }

    function setValidto($validto) {
        $this->validto = $validto;
    }
    function setId($id) {
        $this->id = $id;
    }

        function setRecordedat($recordedat) {
        $this->recordedat = $recordedat;
    }

    function setDeletedat($deletedat) {
        $this->deletedat = $deletedat;
    }

                
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    

   
}
