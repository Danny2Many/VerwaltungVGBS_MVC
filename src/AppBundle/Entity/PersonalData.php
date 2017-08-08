<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class PersonalData {
    
        /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Ein Vorname kann keine Zahl enthalten."
     * )
     *@Assert\Length(
     *      max = 100,
     *      maxMessage = "Der Vorname darf nicht länger als {{ limit }} zeichen sein."
     * )
     */
    protected $firstname;

     /**
     * @ORM\Column(type="string")
     *@Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Ein Name kann keine Zahl enthalten."
     * )
    *@Assert\Length(
     *      max = 100,
     *      maxMessage = "Der Nachname darf nicht länger als {{ limit }} zeichen sein."
     * )
     */
    protected $lastname;
    
    
    
     /**
     * @ORM\Column(type="integer")
      * @Assert\NotBlank()
     * @Assert\Choice(choices = {"0", "1"}, message = "Bitte wählen Sie eine gültige Anrede.")
     */
    protected $title;
    
     /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date(message ="Bitte wählen Sie ein gültiges Datum.")
     */
    protected $birthday;
    
     /**
     * @ORM\Column(type="string")
      * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/[a-zA-ZäöüÄÖÜ \.]+,( )*[a-zA-Z]?[1-9][0-9]{0,2}[a-z]?/",
     * message="Bitte halten Sie sich an das Format.")
     *@Assert\Length(
     *      max = 100,
     *      maxMessage = "Die Straße und Hausnummer dürfen zusammen nicht länger als {{ limit }} Zeichen (einschließlich Leerzeichen) sein."
     * )
     */
    protected $streetaddress;
    
     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$/",
     * message="Bitte geben Sie eine gültige Postleitzahl an.")
     *@Assert\Length(
     *      max = 5,
     *      maxMessage = "Die Postleitzahl darf nicht länger als {{ limit }} Zeichen sein."
     * ) 
     */
    protected $postcode;
    
     /**
     * @ORM\Column(type="text", name="mailbox")
     *@Assert\Length(
     *      max = 100,
     *      maxMessage = "Das Postfach darf nicht länger als {{ limit }} Zeichen (einschließlich Leerzeichen) sein."
     * ) 
     * 
     */
    protected $mailbox;
    
     /**
     * @ORM\Column(type="string")
        * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Ein Ort kann keine Zahl enthalten."
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Der Ort darf nicht länger als {{ limit }} Zeichen (einschließlich Leerzeichen) sein."
     * )
     */
    protected $location;
    

    /**
     * @ORM\Column(type="string", options={"default":"-"})
     * @Assert\Email(message = "Die E-Mail '{{ value }}' ist keine gültige E-Mail.",
     *     checkMX = true)
     *@Assert\Length(
     *      max = 100,
     *      maxMessage = "Die E-Mail-Adresse darf nicht länger als {{ limit }} Zeichen (einschließlich Leerzeichen) sein."
     * )
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

    function getMailbox() {
        return $this->mailbox;
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

    function setMailbox($mailbox) {
        $this->mailbox = $mailbox;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    

    function setEmail($email) {
        $this->email = $email;
    }



}
