<?php



namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class TestIntern_SG {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $teid;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $sgid;
    
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
    
    function getTeid() {
        return $this->teid;
    }

    function getSgid() {
        return $this->sgid;
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

    function setTeid($teid) {
        $this->teid = $teid;
    }

    function setSgid($sgid) {
        $this->sgid = $sgid;
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


}
