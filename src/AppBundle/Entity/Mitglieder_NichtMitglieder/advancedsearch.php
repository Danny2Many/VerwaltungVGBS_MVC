<?php


namespace AppBundle\Entity\Mitglieder_NichtMitglieder;
use Symfony\Component\Validator\Constraints as Assert;





class advancedsearch
{

    /**
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Bitte geben sie eine Zahl größer als {{ limit }} ein.",
     * )
     */
    protected $rehabunits;
    

    /**
    * @Assert\Date()
    *
    * @Assert\Date(message ="Bitte halten sie sich an das gegebene Format")
    */
    public $terminationdate;
    
    
    
    public $terminationdatecompoperators;
    public $rehabunitscompoperators;
    
    function getRehabunits() {
        return $this->rehabunits;
    }

    function getTerminationdate() {
        return $this->terminationdate;
    }

    function setRehabunits($rehabunits) {
        $this->rehabunits = $rehabunits;
    }

    function setTerminationdate($terminationdate) {
        $this->terminationdate = $terminationdate;
    }

    function getTerminationdatecompoperators() {
        return $this->terminationdatecompoperators;
    }

    function getRehabunitscompoperators() {
        return $this->rehabunitscompoperators;
    }

    function setTerminationdatecompoperators($terminationdatecompoperators) {
        $this->terminationdatecompoperators = $terminationdatecompoperators;
    }

    function setRehabunitscompoperators($rehabunitscompoperators) {
        $this->rehabunitscompoperators = $rehabunitscompoperators;
    }


     
}
