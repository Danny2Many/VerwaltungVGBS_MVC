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
     * 
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

    function setRecordedat($recordedat) {
        $this->recordedat = $recordedat;
    }

    function setDeletedat($deletedat) {
        $this->deletedat = $deletedat;
    }

        
    
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
