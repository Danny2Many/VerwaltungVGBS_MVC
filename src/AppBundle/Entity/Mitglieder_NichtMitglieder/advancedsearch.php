<?php


namespace AppBundle\Entity\Mitglieder_NichtMitglieder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;





class advancedsearch
{

    /**
     * @Assert\Type("int")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "Bitte geben sie eine Zahl größer-gleich {{ limit }} ein.",
     * )
     */
    protected $rehabunits;
    

    /**
    *
    * @Assert\Date(message ="Bitte geben Sie ein gültiges Datum an.")
    */
    public $terminationdate;
    
    
    
    public $terminationdatecompoperators;
    public $rehabunitscompoperators;
    
    public $sportsgroup;
    public $membersportsgroupstate;
    
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload=null)
    {
        if($this->allFieldsAreEmpty())
        {
            $context->buildViolation('Um eine Suche durchführen zu können, werden Such-Parameter benötigt.')
                    ->atPath('form')
                    ->addViolation();
        }
        else
        {
            $tdcompoperatormapping = array(''=> null, '=' => 'Zu', '<' => 'Vor', '>' => 'Nach');
            $termDateViolationText = $tdcompoperatormapping[$this->getTerminationdatecompoperators()].' welchem Datum läuft der Rehaschein ab?';
            
            $this->buildBothFieldsAreNotFilledViolation($this->getTerminationdatecompoperators(), $this->getTerminationdate(), $termDateViolationText, 'terminationdate', $context);
            $this->buildBothFieldsAreNotFilledViolation($this->getTerminationdate(), $this->getTerminationdatecompoperators(), 'Bitte geben Sie einen Zeitraum an.', 'terminationdatecompoperators', $context);

            $this->buildBothFieldsAreNotFilledViolation($this->getRehabunitscompoperators(), $this->getRehabunits(), 'Bitte geben Sie die Anzahl der Einheiten an.', 'rehabunits', $context);
            $this->buildBothFieldsAreNotFilledViolation($this->getRehabunits(), $this->getRehabunitscompoperators(), 'Bitte geben Sie einen Vergleichsoperator an.', 'rehabunitscompoperators', $context);
            
            $membersportsgroupstate = $this->getMembersportsgroupstate();
            $this->buildBothFieldsAreNotFilledViolation($membersportsgroupstate, $this->getSportsgroup(), 'Bitte geben wählen Sie ein Sportgruppe,in welche eine Person '.$membersportsgroupstate.' sein soll.', 'rehabunits', $context);
            $this->buildBothFieldsAreNotFilledViolation($this->getRehabunits(), $this->getRehabunitscompoperators(), 'Bitte geben Sie einen Vergleichsoperator an.', 'rehabunitscompoperators', $context);

        }
    }
    
    private function buildBothFieldsAreNotFilledViolation($notEmptyVar, $emptyVar, $violationText, $path, $context)
    {
        if(!empty($notEmptyVar) && empty($emptyVar))
        {
            $context->buildViolation($violationText)
                    ->atPath($path)
                    ->addViolation();
        }
    }
    
    function allFieldsAreEmpty()
    {
        $properties = array_filter(get_object_vars($this));
        return empty($properties);

    }
    
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


    function getSportsgroup() {
        return $this->sportsgroup;
    }

    function setSportsgroup($sportsgroup) {
        $this->sportsgroup = $sportsgroup;
    }


    function getMembersportsgroupstate() {
        return $this->membersportsgroupstate;
    }

    function setMembersportsgroupstate($membersportsgroupstate) {
        $this->membersportsgroupstate = $membersportsgroupstate;
    }


}
