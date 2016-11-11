<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestExternSG")
 * 
 */
class TestExternSG {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     */
    protected $name;

     /**
     * @ORM\Column(type="string")
     */
    
    protected $info;
    
    
    
     /**
     * @ORM\Column(type="string")
      * @Assert\NotBlank()
     * 
     */
    protected $room;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getInfo() {
        return $this->info;
    }

    function getRoom() {
        return $this->room;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setInfo($info) {
        $this->info = $info;
    }

    function setRoom($room) {
        $this->room = $room;
    }



}
