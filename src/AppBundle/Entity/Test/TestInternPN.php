<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestInternPN")
 * 
 */
class TestInternPN {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * 
     */
    protected $id;
    
    /**
     * 
     * @ORM\Column(type="integer") 
     * 
     */
    protected $pid;
    
    
    
    /**
     * @ORM\Column(type="string")
       * @Assert\NotBlank()
     */
    protected $phonenumber;

     


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
    
    function setId($id) {
        $this->id = $id;
    }

        function getPid() {
        return $this->pid;
    }

   

    function setPid($pid) {
        $this->pid = $pid;
    }

    

        
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
     * @return TestInternPN
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

    
}
